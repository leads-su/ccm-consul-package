<?php

namespace ConsulConfigManager\Consul\Test\Unit\Domain\Service\Events;

use ConsulConfigManager\Consul\Domain\Service\Events\ServiceUpdated;

/**
 * Class ServiceUpdatedTest
 * @package ConsulConfigManager\Consul\Test\Unit\Domain\Service\Events
 */
class ServiceUpdatedTest extends AbstractEventTest
{
    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfEventCanBeUpdated(array $data): void
    {
        $instance = new ServiceUpdated($data);
        $this->assertInstanceOf(ServiceUpdated::class, $instance);
    }

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfValidDataReturnedFromGetConfigurationMethod(array $data): void
    {
        $instance = new ServiceUpdated($data);
        $this->assertEquals($data, $instance->getConfiguration());
    }
}
