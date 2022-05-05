<?php

namespace ConsulConfigManager\Consul\Test\Unit\Domain\ACL\Policy;

use ConsulConfigManager\Consul\Test\TestCase;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;
use ConsulConfigManager\Consul\Domain\ACL\Policy\ACLPolicyAggregateRoot;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Events\ACLPolicyCreated;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Events\ACLPolicyDeleted;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Events\ACLPolicyUpdated;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventCollection;

/**
 * Class ACLPolicyAggregateRootTest
 * @package ConsulConfigManager\Consul\Test\Unit\Domain\ACL\Policy
 */
class ACLPolicyAggregateRootTest extends TestCase
{
    /**
     * Common UUID value
     * @var string
     */
    private string $uuid = 'c1dbd8d3-9547-4d2a-a181-ec035fbaaaed';

    /**
     * Common ID value
     * @var string
     */
    private string $id = '1e8f8bb7-0111-450a-3f05-56d4e3911bb9';

    /**
     * Common name
     * @var string
     */
    private string $name = 'example_policy';

    /**
     * Common description
     * @var string
     */
    private string $description = 'This is an example policy.';

    /**
     * Common rules
     * @var string
     */
    private string $rules = '';

    public function testShouldPassIfInstanceOfAggregateRootIsReturnedFromCreateMethod(): void
    {
        $instance = ACLPolicyAggregateRoot::retrieve($this->uuid)
            ->createEntity(
                $this->id,
                $this->name,
                $this->description,
                $this->rules
            )
            ->persist();

        $this->assertInstanceOf(ACLPolicyAggregateRoot::class, $instance);
        $this->assertTrue($this->hasEventStored(ACLPolicyCreated::class));
    }

    public function testShouldPassIfInstanceOfAggregateRootIsReturnedFromUpdateMethod(): void
    {
        $instance = ACLPolicyAggregateRoot::retrieve($this->uuid)
            ->createEntity(
                $this->id,
                $this->name,
                $this->description,
                $this->rules
            )
            ->updateEntity(
                $this->name,
                'Hi',
                $this->rules
            )
            ->persist();
        $this->assertInstanceOf(ACLPolicyAggregateRoot::class, $instance);
        $this->assertTrue($this->hasEventStored(ACLPolicyCreated::class));
        $this->assertTrue($this->hasEventStored(ACLPolicyUpdated::class));
    }

    public function testShouldPassIfInstanceOfAggregateRootIsReturnedFromDeleteMethod(): void
    {
        $instance = ACLPolicyAggregateRoot::retrieve($this->uuid)
            ->createEntity(
                $this->id,
                $this->name,
                $this->description,
                $this->rules
            )
            ->updateEntity(
                $this->name,
                'Hi',
                $this->rules
            )
            ->deleteEntity()
            ->persist();
        $this->assertInstanceOf(ACLPolicyAggregateRoot::class, $instance);
        $this->assertTrue($this->hasEventStored(ACLPolicyCreated::class));
        $this->assertTrue($this->hasEventStored(ACLPolicyUpdated::class));
        $this->assertTrue($this->hasEventStored(ACLPolicyDeleted::class));
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
