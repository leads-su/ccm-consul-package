<?php

namespace ConsulConfigManager\Consul\Test\Unit\Domain\KeyValue\Events;

use Illuminate\Support\Arr;
use ConsulConfigManager\Consul\Domain\KeyValue\Events\KeyValueUpdated;

/**
 * Class KeyValueUpdatedTest
 *
 * @package ConsulConfigManager\Consul\Test\Unit\Domain\KeyValue\Events
 */
class KeyValueUpdatedTest extends AbstractEventTest
{
    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfEventCanBeCreated(array $data): void
    {
        $instance = new KeyValueUpdated(Arr::get($data, 'value'), Arr::get($data, 'user'));
        $this->assertInstanceOf(KeyValueUpdated::class, $instance);
    }

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfValidDataReturnedFromGetValueMethod(array $data): void
    {
        $instance = new KeyValueUpdated(Arr::get($data, 'value'), Arr::get($data, 'user'));
        $this->assertEquals(Arr::get($data, 'value'), $instance->getValue());
    }
}
