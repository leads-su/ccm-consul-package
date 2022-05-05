<?php

namespace ConsulConfigManager\Consul\Test\Unit\Domain\Service;

use Illuminate\Support\Arr;
use ConsulConfigManager\Consul\Test\TestCase;
use ConsulConfigManager\Consul\Models\Service;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;
use ConsulConfigManager\Consul\Domain\Service\ServiceAggregateRoot;
use ConsulConfigManager\Consul\Domain\Service\Events\ServiceCreated;
use ConsulConfigManager\Consul\Domain\Service\Events\ServiceDeleted;
use ConsulConfigManager\Consul\Domain\Service\Events\ServiceUpdated;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventCollection;

/**
 * Class ServiceAggregateRootTest
 * @package ConsulConfigManager\Consul\Test\Unit\Domain\Service
 */
class ServiceAggregateRootTest extends TestCase
{
    /**
     * Common UUID value
     * @var string
     */
    private string $uuid = 'c1dbd8d3-9547-4d2a-a181-ec035fbbbbec';

    public function testShouldPassIfInstanceOfAggregateRootIsReturnedFromCreateMethod(): void
    {
        $instance = ServiceAggregateRoot::retrieve($this->uuid)
            ->createEntity($this->serviceConfiguration())
            ->persist();

        $this->assertInstanceOf(ServiceAggregateRoot::class, $instance);
        $this->assertTrue($this->hasEventStored(ServiceCreated::class));
    }

    public function testShouldPassIfInstanceOfAggregateRootIsReturnedFromUpdateMethod(): void
    {
        $instance = ServiceAggregateRoot::retrieve($this->uuid)
            ->createEntity($this->serviceConfiguration())
            ->updateEntity($this->updatedServiceConfiguration())
            ->persist();
        $this->assertInstanceOf(ServiceAggregateRoot::class, $instance);
        $this->assertTrue($this->hasEventStored(ServiceCreated::class));
        $this->assertTrue($this->hasEventStored(ServiceUpdated::class));
    }

    public function testShouldPassIfInstanceOfAggregateRootIsReturnedFromDeleteMethod(): void
    {
        $instance = ServiceAggregateRoot::retrieve($this->uuid)
            ->createEntity($this->serviceConfiguration())
            ->updateEntity($this->updatedServiceConfiguration())
            ->deleteEntity()
            ->persist();
        $this->assertInstanceOf(ServiceAggregateRoot::class, $instance);
        $this->assertTrue($this->hasEventStored(ServiceCreated::class));
        $this->assertTrue($this->hasEventStored(ServiceUpdated::class));
        $this->assertTrue($this->hasEventStored(ServiceDeleted::class));
    }

    /**
     * Generate service configuration for create event
     * @return array
     */
    private function serviceConfiguration(): array
    {
        return [
            'id'                        =>  'ccm-example-127.0.0.1',
            'service'                   =>  'ccm',
            'address'                   =>  '127.0.0.1',
            'port'                      =>  32175,
            'datacenter'                =>  'dc0',
            'tags'                      =>  [],
            'meta'                      =>  [
                'operating_system'      =>  'linux',
                'log_level'             =>  'DEBUG',
                'go_version'            =>  '1.17.2',
                'environment'           =>  'development',
                'architecture'          =>  'amd64',
                'application_version'   =>  '99.9.9',
            ],
            'online'                    =>  true,
        ];
    }

    /**
     * Generate service configuration for update event
     * @return array
     */
    private function updatedServiceConfiguration(): array
    {
        $configuration = $this->serviceConfiguration();
        Arr::set($configuration, 'datacenter', 'dc1');
        return $configuration;
    }

    /**
     * Check that event has been recorded
     * @param string $eventClass
     * @return bool
     */
    private function hasEventStored(string $eventClass): bool
    {
        $hasEvent = false;

        /**
         * @var EloquentStoredEventCollection $response
         */
        $response = EloquentStoredEvent::where('aggregate_uuid', '=', $this->uuid)->get();

        if ($response->count() > 0) {
            foreach ($response as $event) {
                if ($event->event_class === $eventClass) {
                    $hasEvent = true;
                    break;
                }
            }
        }

        return $hasEvent;
    }
}
