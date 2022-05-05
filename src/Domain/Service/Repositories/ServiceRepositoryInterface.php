<?php

namespace ConsulConfigManager\Consul\Domain\Service\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use ConsulConfigManager\Consul\Domain\Service\Interfaces\ServiceEntity;

/**
 * Interface ServiceRepositoryInterface
 * @package ConsulConfigManager\Consul\Domain\Service\Repositories
 */
interface ServiceRepositoryInterface
{
    /**
     * Get list of all service entries from database
     * @param array|string[] $columns
     *
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection;

    /**
     * Find entity by path
     * @param string         $identifier
     * @param array|string[] $columns
     *
     * @return ServiceEntity|Model|null
     */
    public function find(string $identifier, array $columns = ['*']): ServiceEntity|Model|null;

    /**
     * Find entity by path or fail
     * @param string         $identifier
     * @param array|string[] $columns
     *
     * @throws ModelNotFoundException
     * @return ServiceEntity
     */
    public function findOrFail(string $identifier, array $columns = ['*']): ServiceEntity;

    /**
     * Create new entity
     * @param array $configuration
     *
     * @return ServiceEntity
     */
    public function create(array $configuration): ServiceEntity;

    /**
     * Update existing entity
     * @param array $configuration
     *
     * @return ServiceEntity
     */
    public function update(array $configuration): ServiceEntity;

    /**
     * Delete existing entity
     * @param string $identifier
     * @param bool   $forceDelete
     *
     * @return bool
     */
    public function delete(string $identifier, bool $forceDelete = false): bool;

    /**
     * Force delete existing entity
     * @param string $identifier
     *
     * @return bool
     */
    public function forceDelete(string $identifier): bool;
}
