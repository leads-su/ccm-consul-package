<?php

namespace ConsulConfigManager\Consul\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;
use ConsulConfigManager\Consul\Database\Factories\ServiceFactory;
use ConsulConfigManager\Consul\Domain\Service\ServiceAggregateRoot;
use ConsulConfigManager\Consul\Domain\Service\Interfaces\ServiceEntity;

/**
 * Class Service
 * @package ConsulConfigManager\Consul\Models
 *
 * @property integer $id
 * @property string $uuid
 * @property string $identifier
 * @property string $service
 * @property string $address
 * @property integer $port
 * @property string $datacenter
 * @property array $tags
 * @property array $meta
 * @property boolean $online
 * @property string $environment
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @property Carbon  $deleted_at
 */
class Service extends Model implements ServiceEntity
{
    use SoftDeletes;
    use HasFactory;

    /**
     * @inheritDoc
     */
    public $table = 'consul_services';

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'uuid',
        'identifier',
        'service',
        'address',
        'port',
        'datacenter',
        'tags',
        'meta',
        'online',
        'environment',
    ];

    /**
     * @inheritDoc
     */
    protected $casts = [
        'id'            =>  'integer',
        'uuid'          =>  'string',
        'identifier'    =>  'string',
        'service'       =>  'string',
        'address'       =>  'string',
        'port'          =>  'integer',
        'datacenter'    =>  'string',
        'tags'          =>  'array',
        'meta'          =>  'array',
        'online'        =>  'boolean',
        'environment'   =>  'string',
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
    protected string $aggregateRoot = ServiceAggregateRoot::class;

    /**
     * Retrieve model by UUID
     *
     * @param string $uuid
     * @param bool   $withTrashed
     *
     * @return Service|null
     */
    public static function uuid(string $uuid, bool $withTrashed = false): ?Service
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
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    /**
     * @inheritDoc
     */
    public function setID(int $id): self
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
    public function setUuid(string $uuid): self
    {
        $this->attributes['uuid'] = $uuid;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getIdentifier(): string
    {
        return (string) $this->attributes['identifier'];
    }

    /**
     * @inheritDoc
     */
    public function setIdentifier(string $identifier): ServiceEntity
    {
        $this->attributes['identifier'] = $identifier;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getService(): string
    {
        return (string) $this->attributes['service'];
    }

    /**
     * @inheritDoc
     */
    public function setService(string $service): ServiceEntity
    {
        $this->attributes['service'] = $service;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAddress(): string
    {
        return (string) $this->attributes['address'];
    }

    /**
     * @inheritDoc
     */
    public function setAddress(string $address): ServiceEntity
    {
        $this->attributes['address'] = $address;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPort(): int
    {
        return (int) $this->attributes['port'];
    }

    /**
     * @inheritDoc
     */
    public function setPort(int $port): ServiceEntity
    {
        $this->attributes['port'] = $port;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDatacenter(): string
    {
        return (string) $this->attributes['datacenter'];
    }

    /**
     * @inheritDoc
     */
    public function setDatacenter(string $datacenter): ServiceEntity
    {
        $this->attributes['datacenter'] = $datacenter;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTags(): array
    {
        return (array) json_decode($this->attributes['tags'], true);
    }

    /**
     * @inheritDoc
     */
    public function setTags(array $tags): ServiceEntity
    {
        $this->attributes['tags'] = json_encode($tags);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMeta(): array
    {
        return (array) json_decode($this->attributes['meta'], true);
    }

    /**
     * @inheritDoc
     */
    public function setMeta(array $meta): ServiceEntity
    {
        $this->attributes['meta'] = json_encode($meta);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isOnline(): bool
    {
        return (bool) $this->attributes['online'];
    }

    /**
     * @inheritDoc
     */
    public function setOnline(bool $online): ServiceEntity
    {
        $this->attributes['online'] = $online;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getEnvironment(): string
    {
        return (string) $this->attributes['environment'];
    }

    /**
     * @inheritDoc
     */
    public function setEnvironment(string $environment): ServiceEntity
    {
        $this->attributes['environment'] = $environment;
        return $this;
    }

    /**
     * @inheritDoc
     */
    protected static function newFactory(): Factory
    {
        return ServiceFactory::new();
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
