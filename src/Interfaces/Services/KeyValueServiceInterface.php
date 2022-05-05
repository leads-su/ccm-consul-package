<?php

namespace ConsulConfigManager\Consul\Interfaces\Services;

use JsonException;
use Consul\Exceptions\RequestException;
use ConsulConfigManager\Consul\Exceptions\KeyValueAlreadyExistsException;
use ConsulConfigManager\Consul\Exceptions\KeyValueDoesNotExistsException;

/**
 * Interface KeyValueServiceInterface
 *
 * @package ConsulConfigManager\Consul\Interfaces\Services
 */
interface KeyValueServiceInterface
{
    /**
     * Get value of specified key
     * @param string $key
     *
     * @throws RequestException
     * @return array
     */
    public function getKeyValue(string $key): array;

    /**
     * Get list of keys in a specified prefix
     * @param string $prefix
     *
     * @throws RequestException
     * @return array
     */
    public function getKeysList(string $prefix = ''): array;

    /**
     * Get keys recursively treating provided key as prefix
     * @param string $prefix
     *
     * @throws RequestException
     * @return array
     */
    public function getKeysValuesInPrefix(string $prefix): array;

    /**
     * Create new KeyValue entry
     * @param string $key
     * @param array  $value
     *
     * @throws JsonException
     * @throws KeyValueAlreadyExistsException
     * @throws RequestException
     * @return bool
     */
    public function createKeyValue(string $key, array $value): bool;

    /**
     * Update existing KeyValue entry
     * @param string $key
     * @param array  $value
     *
     * @throws JsonException
     * @throws KeyValueDoesNotExistsException
     * @return bool
     */
    public function updateKeyValue(string $key, array $value): bool;

    /**
     * Create or Update KeyValue entry
     * @param string $key
     * @param array  $value
     *
     * @throws JsonException
     * @throws RequestException
     * @return bool
     */
    public function createOrUpdateKeyValue(string $key, array $value): bool;

    /**
     * Delete key from Consul
     * @param string $key
     *
     * @throws RequestException
     * @return bool
     */
    public function deleteKey(string $key): bool;
}
