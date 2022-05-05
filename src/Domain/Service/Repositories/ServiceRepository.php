<?php

namespace ConsulConfigManager\Consul\Domain\Service\Repositories;

use Throwable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use ConsulConfigManager\Consul\Models\Service;
use ConsulConfigManager\Consul\Domain\Service\ServiceAggregateRoot;
use ConsulConfigManager\Consul\Domain\Service\Interfaces\ServiceEntity;

/**
 * Class ServiceRepository
 * @package ConsulConfigManager\Consul\Domain\Service\Repositories
 */
class ServiceRepository implements ServiceRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function all(array $columns = ['*']): Collection
    {
        return Service::all($columns);
    }

    /**
     * @inheritDoc
     */
    public function find(string $identifier, array $columns = ['*']): ServiceEntity|Model|null
    {
        return Service::where('identifier', '=', $identifier)->first($columns);
    }

    /**
     * @inheritDoc
     */
    public function findOrFail(string $identifier, array $columns = ['*']): ServiceEntity
    {
        return Service::where('identifier', '=', $identifier)->firstOrFail($columns);
    }

    /**
     * @inheritDoc
     */
    public function create(array $configuration): ServiceEntity
    {
        $uuid = Str::uuid()->toString();
        ServiceAggregateRoot::retrieve($uuid)
            ->createEntity($configuration)
            ->persist();
        return $this->find(Arr::get($configuration, 'id'));
    }

    /**
     * @inheritDoc
     */
    public function update(array $configuration): ServiceEntity
    {
        $model = $this->findOrFail(Arr::get($configuration, 'id'), ['uuid']);
        ServiceAggregateRoot::retrieve($model->getUuid())
            ->updateEntity($configuration)
            ->persist();
        return $this->find($model->getIdentifier());
    }

    /**
     * @inheritDoc
     */
    public function delete(string $identifier, bool $forceDelete = false): bool
    {
        try {
            $model = $this->findOrFail($identifier, ['uuid']);
            ServiceAggregateRoot::retrieve($model->getUuid())
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
    public function forceDelete(string $identifier): bool
    {
        return $this->delete($identifier, true);
    }
}
