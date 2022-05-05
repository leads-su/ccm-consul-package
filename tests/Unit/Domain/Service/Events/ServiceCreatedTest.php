<?php

namespace ConsulConfigManager\Consul\Test\Unit\Domain\Service\Events;

use ConsulConfigManager\Consul\Domain\Service\Events\ServiceCreated;

/**
 * Class ServiceCreatedTest
 * @package ConsulConfigManager\Consul\Test\Unit\Domain\Service\Events
 */
class ServiceCreatedTest extends AbstractEventTest
{
    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfEventCanBeCreated(array $data): void
    {
        $instance = new ServiceCreated($data);
        $this->assertInstanceOf(ServiceCreated::class, $instance);
    }

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfValidDataReturnedFromGetConfigurationMethod(array $data): void
    {
        $instance = new ServiceCreated($data);
        $this->assertEquals($data, $instance->getConfiguration());
    }
}
