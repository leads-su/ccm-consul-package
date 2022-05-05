<?php

namespace ConsulConfigManager\Consul\Test\Unit\Domain\ACL\Policy\Events;

use Illuminate\Support\Arr;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Events\ACLPolicyCreated;

/**
 * Class ACLPolicyCreatedTest
 * @package ConsulConfigManager\Consul\Test\Unit\Domain\ACL\Policy\Events
 */
class ACLPolicyCreatedTest extends AbstractEventTest
{
    /**
     * @inheritDoc
     */
    protected string $activeEventHandler = ACLPolicyCreated::class;

    /**
     * @param array $data
     * @dataProvider eventDataProvider
     * @return void
     */
    public function testShouldPassIfEventCanBeCreated(array $data): void
    {
        $this->assertInstanceOf(ACLPolicyCreated::class, $this->eventInstance($data));
    }

    /**
     * @param array $data
     * @dataProvider eventDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromGetIdMethod(array $data): void
    {
        $this->assertEquals(Arr::get($data, 'id'), $this->eventInstance($data)->getID());
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
     * @return ACLPolicyCreated
     */
    private function eventInstance(array $data): ACLPolicyCreated
    {
        return new ACLPolicyCreated(
            Arr::get($data, 'id'),
            Arr::get($data, 'name'),
            Arr::get($data, 'description'),
            Arr::get($data, 'rules'),
        );
    }
}
