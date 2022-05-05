<?php

namespace ConsulConfigManager\Consul\Domain\ACL\Policy\Repositories;

use Throwable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use ConsulConfigManager\Consul\Models\Policy;
use ConsulConfigManager\Consul\Domain\ACL\Policy\ACLPolicyAggregateRoot;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Interfaces\ACLPolicyEntity;

/**
 * Class ACLPolicyRepository
 * @package ConsulConfigManager\Consul\Domain\ACL\Policy\Repositories
 */
class ACLPolicyRepository implements ACLPolicyRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function all(array $columns = ['*']): Collection
    {
        return Policy::all($columns);
    }

    /**
     * @inheritDoc
     */
    public function find(string $id, array $columns = ['*']): ACLPolicyEntity|Model|null
    {
        return $this->findBy('id', $id, $columns);
    }

    /**
     * @inheritDoc
     */
    public function findOrFail(string $id, array $columns = ['*']): ACLPolicyEntity|Model
    {
        return $this->findByOrFail('id', $id, $columns);
    }

    /**
     * @inheritDoc
     */
    public function findBy(string $field, string $value, array $columns = ['*']): ACLPolicyEntity|Model|null
    {
        return Policy::where($field, '=', $value)->first($columns);
    }

    /**
     * @inheritDoc
     */
    public function findByOrFail(string $field, string $value, array $columns = ['*']): ACLPolicyEntity|Model
    {
        return Policy::where($field, '=', $value)->firstOrFail($columns);
    }

    /**
     * @inheritDoc
     */
    public function findByMany(array $fields, string $value, array $columns = ['*']): ACLPolicyEntity|Model|null
    {
        $query = Policy::query();
        foreach ($fields as $index => $field) {
            if ($index === 0) {
                $query = $query->where($field, '=', $value);
            } else {
                $query = $query->orWhere($field, '=', $value);
            }
        }
        return $query->first($columns);
    }

    /**
     * @inheritDoc
     */
    public function findByManyOrFail(array $fields, string $value, array $columns = ['*']): ACLPolicyEntity|Model
    {
        $query = Policy::query();
        foreach ($fields as $index => $field) {
            if ($index === 0) {
                $query = $query->where($field, '=', $value);
            } else {
                $query = $query->orWhere($field, '=', $value);
            }
        }
        return $query->firstOrFail($columns);
    }

    /**
     * @inheritDoc
     */
    public function create(string $id, string $name, string $description, string $rules): ACLPolicyEntity
    {
        $uuid = Str::uuid()->toString();
        ACLPolicyAggregateRoot::retrieve($uuid)
            ->createEntity($id, $name, $description, $rules)
            ->persist();
        return Policy::uuid($uuid);
    }

    /**
     * @inheritDoc
     */
    public function update(string $id, string $name, string $description, string $rules): ACLPolicyEntity
    {
        $model = $this->findOrFail($id, ['uuid']);
        ACLPolicyAggregateRoot::retrieve($model->getUuid())
            ->updateEntity($name, $description, $rules)
            ->persist();
        return Policy::uuid($model->getUuid());
    }

    /**
     * @inheritDoc
     */
    public function delete(string $id, bool $forceDelete = false): bool
    {
        try {
            $model = $this->findOrFail($id, ['uuid']);
            ACLPolicyAggregateRoot::retrieve($model->getUuid())
                ->deleteEntity()
                ->persist();
            return true;
        } catch (Throwable) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function forceDelete(string $id): bool
    {
        return $this->delete($id, true);
    }
}
