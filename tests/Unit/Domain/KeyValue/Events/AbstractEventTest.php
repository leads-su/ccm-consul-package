<?php

namespace ConsulConfigManager\Consul\Test\Unit\Domain\KeyValue\Events;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use ConsulConfigManager\Users\Models\User;
use ConsulConfigManager\Consul\Test\TestCase;
use ConsulConfigManager\Users\ValueObjects\EmailValueObject;
use ConsulConfigManager\Users\ValueObjects\UsernameValueObject;
use ConsulConfigManager\Consul\Domain\KeyValue\Events\KeyValueCreated;

/**
 * Class AbstractEventTest
 *
 * @package ConsulConfigManager\Consul\Test\Unit\Domain\KeyValue\Events
 */
abstract class AbstractEventTest extends TestCase
{
    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfValidDataReturnedFromGetDateTimeMethod(array $data): void
    {
        $instance = new KeyValueCreated(Arr::get($data, 'path'), Arr::get($data, 'value'), Arr::get($data, 'user'));
        $this->assertNotEquals(0, $instance->getDateTime());
    }

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfValidDataReturnedFromSetDateTimeMethod(array $data): void
    {
        $instance = new KeyValueCreated(Arr::get($data, 'path'), Arr::get($data, 'value'), Arr::get($data, 'user'));

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
     */
    public function testShouldPassIfValidDataReturnedFromGetUserMethod(array $data): void
    {
        $instance = new KeyValueCreated(Arr::get($data, 'path'), Arr::get($data, 'value'));
        $this->assertEquals(0, $instance->getUser());
    }

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfValidDataReturnedFromSetUserMethod(array $data): void
    {
        $instance = new KeyValueCreated(Arr::get($data, 'path'), Arr::get($data, 'value'));
        $instance->setUser(Arr::get($data, 'user'));
        $this->assertEquals(1, $instance->getUser());
    }

    /**
     * Created event data provider
     * @return \array[][]
     */
    public function eventDataProvider(): array
    {
        return [
            'consul/example'            =>  [
                'data'                  =>  [
                    'path'              =>  'consul/example',
                    'value'             =>  [
                        'type'          => 'string',
                        'value'         => 'Hello World',
                    ],
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
}
