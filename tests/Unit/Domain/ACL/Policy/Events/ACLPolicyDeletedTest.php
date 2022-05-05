<?php

namespace ConsulConfigManager\Consul\Test\Unit\Domain\ACL\Policy\Events;

use ConsulConfigManager\Consul\Domain\ACL\Policy\Events\ACLPolicyDeleted;

/**
 * Class ACLPolicyDeletedTest
 * @package ConsulConfigManager\Consul\Test\Unit\Domain\ACL\Policy\Events
 */
class ACLPolicyDeletedTest extends AbstractEventTest
{
    /**
     * @inheritDoc
     */
    protected string $activeEventHandler = ACLPolicyDeleted::class;

    /**
     * @param array $data
     * @dataProvider eventDataProvider
     * @return void
     */
    public function testShouldPassIfEventCanBeCreated(array $data): void
    {
        $this->assertInstanceOf(ACLPolicyDeleted::class, $this->eventInstance($data));
    }

    /**
     * Create new instance of event
     * @param array $data
     * @return ACLPolicyDeleted
     */
    private function eventInstance(array $data): ACLPolicyDeleted
    {
        return new ACLPolicyDeleted();
    }
}
