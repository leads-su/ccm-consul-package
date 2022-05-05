<?php

namespace ConsulConfigManager\Consul\Domain\KeyValue;

use Spatie\EventSourcing\AggregateRoots\AggregateRoot;
use ConsulConfigManager\Users\Interfaces\UserInterface;
use ConsulConfigManager\Consul\Domain\KeyValue\Events\KeyValueCreated;
use ConsulConfigManager\Consul\Domain\KeyValue\Events\KeyValueDeleted;
use ConsulConfigManager\Consul\Domain\KeyValue\Events\KeyValueUpdated;

/**
 * Class KeyValueAggregateRoot
 * @package ConsulConfigManager\Consul\Domain\KeyValue
 */
class KeyValueAggregateRoot extends AggregateRoot
{
    /**
     * Handle `create` event
     * @param string $path
     * @param array $value
     * @param UserInterface|null $user
     * @return $this
     */
    public function createEntity(string $path, array $value, ?UserInterface $user = null): KeyValueAggregateRoot
    {
        $this->recordThat(new KeyValueCreated($path, $value, $user));
        return $this;
    }

    /**
     * Handle `update` event
     * @param array $value
     * @param UserInterface|null $user
     * @return $this
     */
    public function updateEntity(array $value, ?UserInterface $user = null): KeyValueAggregateRoot
    {
        $this->recordThat(new KeyValueUpdated($value, $user));
        return $this;
    }

    /**
     * Handle `delete` event
     * @param UserInterface|null $user
     * @return $this
     */
    public function deleteEntity(?UserInterface $user = null): KeyValueAggregateRoot
    {
        $this->recordThat(new KeyValueDeleted($user));
        return $this;
    }
}
