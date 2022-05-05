<?php

namespace ConsulConfigManager\Consul\Domain\Service;

use Spatie\EventSourcing\AggregateRoots\AggregateRoot;
use ConsulConfigManager\Consul\Domain\Service\Events\ServiceCreated;
use ConsulConfigManager\Consul\Domain\Service\Events\ServiceDeleted;
use ConsulConfigManager\Consul\Domain\Service\Events\ServiceUpdated;

/**
 * Class ServiceAggregateRoot
 * @package ConsulConfigManager\Consul\Domain\Service
 */
class ServiceAggregateRoot extends AggregateRoot
{
    /**
     * Handle `create` event
     * @param array $configuration
     * @return $this
     */
    public function createEntity(array $configuration): ServiceAggregateRoot
    {
        $this->recordThat(new ServiceCreated($configuration));
        return $this;
    }

    /**
     * Handle `update` event
     * @param array $configuration
     * @return $this
     */
    public function updateEntity(array $configuration): ServiceAggregateRoot
    {
        $this->recordThat(new ServiceUpdated($configuration));
        return $this;
    }

    /**
     * Handle `delete` event
     * @return $this
     */
    public function deleteEntity(): ServiceAggregateRoot
    {
        $this->recordThat(new ServiceDeleted());
        return $this;
    }
}
