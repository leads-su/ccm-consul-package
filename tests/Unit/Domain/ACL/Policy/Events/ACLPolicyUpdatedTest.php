<?php

namespace ConsulConfigManager\Consul\Test\Unit\Domain\ACL\Policy\Events;

use Illuminate\Support\Arr;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Events\ACLPolicyUpdated;

/**
 * Class ACLPolicyUpdatedTest
 * @package ConsulConfigManager\Consul\Test\Unit\Domain\ACL\Policy\Events
 */
class ACLPolicyUpdatedTest extends AbstractEventTest
{
    /**
     * @inheritDoc
     */
    protected string $activeEventHandler = ACLPolicyUpdated::class;

    /**
     * @param array $data
     * @dataProvider eventDataProvider
     * @return void
     */
    public function testShouldPassIfEventCanBeCreated(array $data): void
    {
        $this->assertInstanceOf(ACLPolicyUpdated::class, $this->eventInstance($data));
    }

    /**
     * @param array $data
     * @dataProvider eventDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromGetNameMethod(array $data): void
    {
        $this->assertEquals(Arr::get($data, 'name'), $this->eventInstance($data)->getName());
    }

    /**
     * @param array $data
     * @dataProvider eventDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromGetDescriptionMethod(array $data): void
    {
        $this->assertEquals(Arr::get($data, 'description'), $this->eventInstance($data)->getDescription());
    }

    /**
     * @param array $data
     * @dataProvider eventDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromGetRulesMethod(array $data): void
    {
        $this->assertEquals(Arr::get($data, 'rules'), $this->eventInstance($data)->getRules());
    }

    /**
     * Create new instance of event
     * @param array $data
     * @return ACLPolicyUpdated
     */
    private function eventInstance(array $data): ACLPolicyUpdated
    {
        return new ACLPolicyUpdated(
            Arr::get($data, 'name'),
            Arr::get($data, 'description'),
            Arr::get($data, 'rules'),
        );
    }
}
