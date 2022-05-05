<?php

namespace ConsulConfigManager\Consul\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use ConsulConfigManager\Users\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;
use ConsulConfigManager\Consul\Database\Factories\KeyValueFactory;
use ConsulConfigManager\Consul\Domain\KeyValue\KeyValueAggregateRoot;
use ConsulConfigManager\Consul\Domain\KeyValue\Interfaces\KeyValueEntity;
use Spatie\EventSourcing\StoredEvents\Repositories\EloquentStoredEventRepository;

/**
 * Class KeyValue
 *
 * @package ConsulConfigManager\Consul\Models
 * @property integer $id
 * @property string  $uuid
 * @property string  $path
 * @property array   $value
 * @property boolean $reference
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @property Carbon  $deleted_at
 *
 * @method Builder references
 */
class KeyValue extends Model implements KeyValueEntity
{
    use SoftDeletes;
    use HasFactory;

    /**
     * @inheritDoc
     */
    public $table = 'consul_key_values';

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'uuid',
        'path',
        'value',
        'reference',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @inheritDoc
     */
    protected $guarded = [];

    /**
     * @inheritDoc
     */
    protected $hidden = [];

    /**
     * @inheritDoc
     */
    protected $casts = [
        'id'            =>  'integer',
        'uuid'          =>  'string',
        'path'          =>  'string',
        'value'         =>  'array',
        'reference'     =>  'boolean',
    ];

    /**
     * @inheritDoc
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @inheritDoc
     */
    protected $with = [

    ];

    /**
     * Aggregate Root class for model
     * @var string
     */
    protected string $aggregateRoot = KeyValueAggregateRoot::class;

    /**
     * @inheritDoc
     */
    public static function uuid(string $uuid, bool $withTrashed = false): KeyValue|keyValueEntity|null
    {
        $baseQuery = static::where('uuid', '=', $uuid);
        if ($withTrashed) {
            return $baseQuery->withTrashed()->first();
        }
        return $baseQuery->first();
    }

    /**
     * @inheritDoc
     */
    public function getID(): int
    {
        return (int) $this->attributes['id'];
    }

    /**
     * @inheritDoc
     */
    public function setID(int $id): KeyValue
    {
        $this->attributes['id'] = $id;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUuid(): string
    {
        return (string) $this->attributes['uuid'];
    }

    /**
     * @inheritDoc
     */
    public function setUuid(string $uuid): KeyValue
    {
        $this->attributes['uuid'] = $uuid;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return (string) $this->attributes['path'];
    }

    /**
     * @inheritDoc
     */
    public function setPath(string $path): KeyValue
    {
        $this->attributes['path'] = $path;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getValue(): array
    {
        return json_decode($this->attributes['value'], true);
    }

    /**
     * @inheritDoc
     */
    public function setValue(array $value): KeyValue
    {
        $this->attributes['value'] = json_encode($value);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isReference(): bool
    {
        return (bool) $this->attributes['reference'];
    }

    /**
     * @inheritDoc
     */
    public function markAsReference(bool $isReference = true): KeyValue
    {
        $this->attributes['reference'] = $isReference;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function history(?string $uuid = null): Collection
    {
        $storedEventRepository = new EloquentStoredEventRepository();
        if (!$uuid) {
            $aggregateRoot = $this->aggregateRoot();
            $uuid = $aggregateRoot->uuid();
        }

        $storedEvents = $storedEventRepository->retrieveAll($uuid);
        $history = [];

        foreach ($storedEvents as $index => $eventModel) {
            $eventAccessors = array_filter(get_class_methods($eventModel->event), static function (string $method): bool {
                return Str::startsWith($method, 'get') && $method !== 'getUser';
            });

            foreach ($eventAccessors as $accessor) {
                $accessorKey = lcfirst(trim(str_replace('get', '', $accessor)));
                $historyKey = Str::snake($accessorKey);
                $history[$index][$historyKey] = $eventModel->event_properties[$accessorKey];
            }

            Arr::set($history, $index . '.event', [
                'id'        =>  $eventModel->id,
                'uuid'      =>  $eventModel->aggragate_uuid,
                'class'     =>  $eventModel->event_class,
                'version'   =>  $eventModel->aggregate_version,
            ]);

            $eventUser = User::find($eventModel->event_properties['user'])->withoutRelations()->toArray();

            Arr::set($history, $index . '.user', Arr::only($eventUser, [
                'id',
                'first_name',
                'last_name',
                'username',
                'email',
            ]));
        }
        return collect($history);
    }

    /**
     * @inheritDoc
     */
    public function scopeReferences(Builder $query): Builder
    {
        return $query->where('reference', '=', true);
    }

    /**
     * Resolve reference path
     * @param array $value
     * @return array
     */
    public function resolverReferencePath(array $value): array
    {
        $key = Arr::get($value, 'value');
        $referenceModel = KeyValue::where('path', '=', $key)->toArray();
        $referenceValue = Arr::get($referenceModel, 'value');
        if (Arr::get($referenceValue, 'type') === 'reference') {
            $referenceValue = $this->resolverReferencePath($referenceValue);
        }
        return [
            'reference'     =>  $key,
            'value'         =>  $referenceValue,
        ];
    }

    /**
     * Resolve target value for reference
     * @param string|null $key
     * @return array
     */
    public function resolveReferenceValue(?string $key = null): array
    {
        if (!$key) {
            $key = $this->path;
        }
        $referenceModel = KeyValue::where('path', '=', $key)->first('value')->toArray();
        $referenceValue = Arr::get($referenceModel, 'value');
        if (Arr::get($referenceValue, 'type') === 'reference') {
            $referenceValue = $this->resolveReferenceValue(Arr::get($referenceValue, 'value'));
        }
        return $referenceValue;
    }

    /**
     * @inheritDoc
     */
    protected static function newFactory(): Factory
    {
        return KeyValueFactory::new();
    }

    /**
     * Get instance of AggregateRoot
     * @return AggregateRoot
     */
    private function aggregateRoot(): AggregateRoot
    {
        return forward_static_call([$this->aggregateRoot, 'retrieve'], $this->uuid);
    }
}
