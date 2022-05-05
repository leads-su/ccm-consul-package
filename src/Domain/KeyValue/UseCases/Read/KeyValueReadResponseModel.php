<?php

namespace ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Read;

use ConsulConfigManager\Consul\Domain\KeyValue\Interfaces\KeyValueEntity;

/**
 * Class KeyValueReadResponseModel
 * @package ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Read
 */
class KeyValueReadResponseModel
{
    /**
     * KeyValue model instance
     * @var KeyValueEntity|null
     */
    private ?KeyValueEntity $keyValueEntity;

    /**
     * KeyValueReadResponseModel constructor.
     * @param KeyValueEntity|null $keyValueEntity
     * @return void
     */
    public function __construct(?KeyValueEntity $keyValueEntity = null)
    {
        $this->keyValueEntity = $keyValueEntity;
    }

    /**
     * Get key-value
     * @return KeyValueEntity|null
     */
    public function getKeyValue(): ?KeyValueEntity
    {
        return $this->keyValueEntity;
    }
}
