<?php

namespace ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Namespaced;

/**
 * Class KeyValueNamespacedResponseModel
 * @package ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Namespaced
 */
class KeyValueNamespacedResponseModel
{
    /**
     * List of namespaced keys
     * @var array
     */
    private array $namespaced;

    /**
     * KeyValueNamespacedResponseModel constructor.
     * @param array $namespaced
     * @return void
     */
    public function __construct(array $namespaced = [])
    {
        $this->namespaced = $namespaced;
    }

    /**
     * Get list of namespaced keys
     * @return array
     */
    public function getNamespaced(): array
    {
        return $this->namespaced;
    }
}
