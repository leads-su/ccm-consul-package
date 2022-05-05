<?php

namespace ConsulConfigManager\Consul\Domain\ACL\Policy\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Interfaces\ACLPolicyEntity;

/**
 * Interface ACLPolicyRepositoryInterface
 * @package ConsulConfigManager\Consul\Domain\ACL\Policy\Repositories
 */
interface ACLPolicyRepositoryInterface
{
    /**
     * Get list of all entries from database
     * @param array|string[] $columns
     *
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection;

    /**
     * Find entity
     * @param string $id
     * @param array|string[] $columns
     * @return ACLPolicyEntity|Model|null
     */
    public function find(string $id, array $columns = ['*']): ACLPolicyEntity|Model|null;

    /**
     * Find entity or fail and throw exception
     * @param string $id
     * @param array|string[] $columns
     * @throws ModelNotFoundException
     * @return ACLPolicyEntity|Model
     */
    public function findOrFail(string $id, array $columns = ['*']): ACLPolicyEntity|Model;

    /**
     * Find entity by specified field
     * @param string $field
     * @param string $value
     * @param array|string[] $columns
     * @return ACLPolicyEntity|Model|null
     */
    public function findBy(string $field, string $value, array $columns = ['*']): ACLPolicyEntity|Model|null;

    /**
     * Find entity by specified field or throw exception
     * @param string $field
     * @param string $value
     * @param array|string[] $columns
     * @throws ModelNotFoundException
     * @return ACLPolicyEntity|Model
     */
    public function findByOrFail(string $field, string $value, array $columns = ['*']): ACLPolicyEntity|Model;

    /**
     * Find entity while using multiple fields to perform search
     * @param array $fields
     * @param string $value
     * @param array|string[] $columns
     * @return ACLPolicyEntity|Model|null
     */
    public function findByMany(array $fields, string $value, array $columns = ['*']): ACLPolicyEntity|Model|null;

    /**
     * Find entity while using multiple fields to perform search or throw exception
     * @param array $fields
     * @param string $value
     * @param array|string[] $columns
     * @throws ModelNotFoundException
     * @return ACLPolicyEntity|Model
     */
    public function findByManyOrFail(array $fields, string $value, array $columns = ['*']): ACLPolicyEntity|Model;

    /**
     * Create new policy
     * @param string $id
     * @param string $name
     * @param string $description
     * @param string $rules
     * @return ACLPolicyEntity
     */
    public function create(string $id, string $name, string $description, string $rules): ACLPolicyEntity;

    /**
     * Update existing policy
     * @param string $id
     * @param string $name
     * @param string $description
     * @param string $rules
     * @return ACLPolicyEntity
     */
    public function update(string $id, string $name, string $description, string $rules): ACLPolicyEntity;

    /**
     * Delete entity
     * @param string $id
     * @param bool $forceDelete
     * @return bool
     */
    public function delete(string $id, bool $forceDelete = false): bool;

    /**
     * Force entity deletion
     * @param string $id
     * @return bool
     */
    public function forceDelete(string $id): bool;
}
