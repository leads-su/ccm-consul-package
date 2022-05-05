<?php

namespace ConsulConfigManager\Consul\Test\Integration;

use ConsulConfigManager\Consul\Test\TestCase;
use ConsulConfigManager\Consul\Services\AbstractService;

/**
 * Class AbstractServiceTest
 *
 * @package ConsulConfigManager\Consul\Test\Integration
 */
class AbstractServiceTest extends TestCase
{
    /**
     * Class we are currently testing
     * @var AbstractService
     */
    private AbstractService $testedClass;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->testedClass = new class () extends AbstractService {
            public function clientInstance()
            {
                return $this->client();
            }
        };
    }

    public function testShouldPassIfSpecifiedServiceIsOnline(): void
    {
        $response = $this->testedClass->serverOnline(
            config('domain.consul.connections.default.host'),
            config('domain.consul.connections.default.port'),
        );
        $this->assertTrue($response);
    }

    public function testShouldPassIfSpecifiedServerIsOffline(): void
    {
        $response = $this->testedClass->serverOnline(
            config('domain.consul.connections.default.host'),
            1234,
        );
        $this->assertFalse($response);
    }
}
