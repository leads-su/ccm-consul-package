<?php

namespace ConsulConfigManager\Consul\Test\Unit\Domain\KeyValue;

use Illuminate\Support\Arr;
use ConsulConfigManager\Consul\Test\TestCase;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;
use ConsulConfigManager\Consul\Domain\KeyValue\KeyValueAggregateRoot;
use ConsulConfigManager\Consul\Domain\KeyValue\Events\KeyValueCreated;
use ConsulConfigManager\Consul\Domain\KeyValue\Events\KeyValueDeleted;
use ConsulConfigManager\Consul\Domain\KeyValue\Events\KeyValueUpdated;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventCollection;

/**
 * Class KeyValueAggregateRootTest
 *
 * @package ConsulConfigManager\Consul\Test\Unit\Domain\KeyValue
 */
class KeyValueAggregateRootTest extends TestCase
{
    /**
     * Common UUID value
     * @var string
     */
    private string $uuid = 'c1dbd8d3-9547-4d2a-a181-ec035fbaaaed';

    /**
     * Common key path
     * @var string
     */
    private string $path = 'consul/test';

    /**
     * Common key value
     * @var array|string[]
     */
    private array $value = [
        'type'  =>  'string',
        'value' =>  'Hello World!',
    ];

    public function testShouldPassIfInstanceOfAggregateRootIsReturnedFromCreateMethod(): void
    {
        $instance = KeyValueAggregateRoot::retrieve($this->uuid)
            ->createEntity($this->path, $this->value)
            ->persist();

        $this->assertInstanceOf(KeyValueAggregateRoot::class, $instance);
        $this->assertTrue($this->hasEventStored(KeyValueCreated::class));
    }

    public function testShouldPassIfInstanceOfAggregateRootIsReturnedFromUpdateMethod(): void
    {
        $instance = KeyValueAggregateRoot::retrieve($this->uuid)
            ->createEntity($this->path, $this->value)
            ->updateEntity($this->newWorldValue())
            ->persist();
        $this->assertInstanceOf(KeyValueAggregateRoot::class, $instance);
        $this->assertTrue($this->hasEventStored(KeyValueCreated::class));
        $this->assertTrue($this->hasEventStored(KeyValueUpdated::class));
    }

    public function testShouldPassIfInstanceOfAggregateRootIsReturnedFromDeleteMethod(): void
    {
        $instance = KeyValueAggregateRoot::retrieve($this->uuid)
            ->createEntity($this->path, $this->value)
            ->updateEntity($this->newWorldValue())
            ->deleteEntity()
            ->persist();
        $this->assertInstanceOf(KeyValueAggregateRoot::class, $instance);
        $this->assertTrue($this->hasEventStored(KeyValueCreated::class));
        $this->assertTrue($this->hasEventStored(KeyValueUpdated::class));
        $this->assertTrue($this->hasEventStored(KeyValueDeleted::class));
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

    /**
     * Key value array used for update event
     * @return array|string[]
     */
    private function newWorldValue(): array
    {
        $value = $this->value;
        Arr::set($value, 'value', 'Hello New World!');
        return $value;
    }
}
