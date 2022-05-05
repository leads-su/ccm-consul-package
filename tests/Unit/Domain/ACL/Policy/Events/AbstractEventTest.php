<?php

namespace ConsulConfigManager\Consul\Test\Unit\Domain\ACL\Policy\Events;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use ConsulConfigManager\Users\Models\User;
use ConsulConfigManager\Consul\Test\TestCase;
use ConsulConfigManager\Users\ValueObjects\EmailValueObject;
use ConsulConfigManager\Consul\Domain\Abstracts\AbstractEvent;
use ConsulConfigManager\Users\ValueObjects\UsernameValueObject;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Events\ACLPolicyCreated;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Events\ACLPolicyDeleted;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Events\ACLPolicyUpdated;

/**
 * Class AbstractEventTest
 * @package ConsulConfigManager\Consul\Test\Unit\Domain\ACL\Policy\Events
 */
abstract class AbstractEventTest extends TestCase
{
    /**
     * Currently active event handler
     * @var string
     */
    protected string $activeEventHandler;

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     * @throws Exception
     */
    public function testShouldPassIfValidDataReturnedFromGetDateTimeMethod(array $data): void
    {
        $this->assertNotEquals(0, $this->createClassInstance($data)->getDateTime());
    }

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     * @throws Exception
     */
    public function testShouldPassIfValidDataReturnedFromSetDateTimeMethod(array $data): void
    {
        $instance = $this->createClassInstance($data);

        /**
         * @var Carbon $carbonInstance
         */
        $carbonInstance = Arr::get($data, 'time');
        $instance->setDateTime($carbonInstance);

        $this->assertEquals($carbonInstance->getTimestamp(), $instance->getDateTime());
    }

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     * @throws Exception
     */
    public function testShouldPassIfValidDataReturnedFromGetUserMethod(array $data): void
    {
        $this->assertEquals(0, $this->createClassInstance($data)->getUser());
    }

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     * @throws Exception
     */
    public function testShouldPassIfValidDataReturnedFromSetUserMethod(array $data): void
    {
        $instance = $this->createClassInstance($data);
        $instance->setUser(Arr::get($data, 'user'));
        $this->assertEquals(1, $instance->getUser());
    }

    /**
     * Event data provider array
     * @return \string[][][]
     */
    public function eventDataProvider(): array
    {
        return [
            'example_policy'            =>  [
                'data'                  =>  [
                    'id'                =>  '1e8f8bb7-0111-450a-3f05-56d4e3911bb9',
                    'name'              =>  'example_policy',
                    'description'       =>  'This is an example policy.',
                    'rules'             =>  '',
                    'time'              =>  Carbon::now(),
                    'user'              =>  new User([
                        'id'            =>  1,
                        'first_name'    =>  'John',
                        'last_name'     =>  'Doe',
                        'username'      =>  new UsernameValueObject('john.doe'),
                        'email'         =>  new EmailValueObject('john.doe@example.com'),
                    ]),

                ],
            ],
        ];
    }

    /**
     * Create new instance of event handler class
     * @param array $data
     * @return AbstractEvent
     * @throws Exception
     */
    private function createClassInstance(array $data): AbstractEvent
    {
        return match ($this->activeEventHandler) {
            ACLPolicyCreated::class => new $this->activeEventHandler(
                Arr::get($data, 'id'),
                Arr::get($data, 'name'),
                Arr::get($data, 'description'),
                Arr::get($data, 'rules'),
            ),
            ACLPolicyUpdated::class => new $this->activeEventHandler(
                Arr::get($data, 'name'),
                Arr::get($data, 'description'),
                Arr::get($data, 'rules'),
            ),
            ACLPolicyDeleted::class => new $this->activeEventHandler(),
            default => throw new Exception('Unknown event handler: ' . $this->activeEventHandler),
        };
    }
}
