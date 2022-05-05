<?php

namespace ConsulConfigManager\Consul\Test\Unit\Domain\KeyValue\Events;

use Illuminate\Support\Arr;
use ConsulConfigManager\Consul\Domain\KeyValue\Events\KeyValueDeleted;

/**
 * Class KeyValueDeletedTest
 *
 * @package ConsulConfigManager\Consul\Test\Unit\Domain\KeyValue\Events
 */
class KeyValueDeletedTest extends AbstractEventTest
{
    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfEventCanBeCreated(array $data): void
    {
        $instance = new KeyValueDeleted(Arr::get($data, 'user'));
        $this->assertInstanceOf(KeyValueDeleted::class, $instance);
    }
}
