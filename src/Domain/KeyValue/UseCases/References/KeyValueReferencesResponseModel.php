<?php

namespace ConsulConfigManager\Consul\Domain\KeyValue\UseCases\References;

/**
 * Class KeyValueReferencesResponseModel
 * @package ConsulConfigManager\Consul\Domain\KeyValue\UseCases\References
 */
class KeyValueReferencesResponseModel
{
    /**
     * List of references
     * @var array
     */
    private array $references;

    /**
     * KeyValueReferencesResponseModel constructor.
     * @param array $references
     * @return void
     */
    public function __construct(array $references = [])
    {
        $this->references = $references;
    }

    /**
     * Get list of namespaced keys
     * @return array
     */
    public function getReferences(): array
    {
        return $this->references;
    }
}
