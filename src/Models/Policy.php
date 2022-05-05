<?php

namespace ConsulConfigManager\Consul\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;
use ConsulConfigManager\Consul\Database\Factories\ACLPolicyFactory;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Interfaces\ACLPolicyEntity;

/**
 * Class Policy
 * @package ConsulConfigManager\Consul\Models
 */
class Policy extends Model implements ACLPolicyEntity
{
    use SoftDeletes;
    use HasFactory;

    /**
     * @inheritDoc
     */
    public $table = 'consul_policies';

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'id',
        'uuid',
        'name',
        'description',
        'rules',
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
        'id'            =>  'string',
        'uuid'          =>  'string',
        'name'          =>  'string',
        'description'   =>  'string',
        'rules'         =>  'string',
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
    protected $with = [];

    /**
     * @inheritDoc
     */
    public static function uuid(string $uuid, bool $withTrashed = false): Policy|ACLPolicyEntity|null
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
    public function getID(): string
    {
        return (string) $this->attributes['id'];
    }

    /**
     * @inheritDoc
     */
    public function setID(string $id): ACLPolicyEntity
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
    public function setUuid(string $uuid): ACLPolicyEntity
    {
        $this->attributes['uuid'] = $uuid;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return (string) $this->attributes['name'];
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): ACLPolicyEntity
    {
        $this->attributes['name'] = $name;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return (string) $this->attributes['description'];
    }

    /**
     * @inheritDoc
     */
    public function setDescription(string $description): ACLPolicyEntity
    {
        $this->attributes['description'] = $description;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRules(): string
    {
        return (string) $this->attributes['rules'];
    }

    /**
     * @inheritDoc
     */
    public function setRules(string $rules): ACLPolicyEntity
    {
        $this->attributes['rules'] = $rules;
        return $this;
    }

    /**
     * @inheritDoc
     */
    protected static function newFactory(): Factory
    {
        return ACLPolicyFactory::new();
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
