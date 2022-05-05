<?php

namespace ConsulConfigManager\Consul\Test\Unit\Domain\KeyValue\Events;

use Illuminate\Support\Arr;
use ConsulConfigManager\Consul\Domain\KeyValue\Events\KeyValueCreated;

/**
 * Class KeyValueCreatedTest
 *
 * @package ConsulConfigManager\Consul\Test\Unit\Domain\KeyValue\Events
 */
class KeyValueCreatedTest extends AbstractEventTest
{
    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfEventCanBeCreated(array $data): void
    {
        $instance = new KeyValueCreated(Arr::get($data, 'path'), Arr::get($data, 'value'), Arr::get($data, 'user'));
        $this->assertInstanceOf(KeyValueCreated::class, $instance);
    }

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfValidDataReturnedFromGetPathMethod(array $data): void
    {
        $instance = new KeyValueCreated(Arr::get($data, 'path'), Arr::get($data, 'value'), Arr::get($data, 'user'));
        $this->assertEquals(Arr::get($data, 'path'), $instance->getPath());
    }

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfValidDataReturnedFromGetValueMethod(array $data): void
    {
        $instance = new KeyValueCreated(Arr::get($data, 'path'), Arr::get($data, 'value'), Arr::get($data, 'user'));
        $this->assertEquals(Arr::get($data, 'value'), $instance->getValue());
    }
}
