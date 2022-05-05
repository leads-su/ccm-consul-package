<?php

namespace ConsulConfigManager\Consul\Test\Unit\Domain\Service\Events;

use ConsulConfigManager\Consul\Domain\Service\Events\ServiceDeleted;

/**
 * Class ServiceUpdatedTest
 * @package ConsulConfigManager\Consul\Test\Unit\Domain\Service\Events
 */
class ServiceDeletedTest extends AbstractEventTest
{
    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfEventCanBeCreated(array $data): void
    {
        $instance = new ServiceDeleted();
        $this->assertInstanceOf(ServiceDeleted::class, $instance);
    }
}
