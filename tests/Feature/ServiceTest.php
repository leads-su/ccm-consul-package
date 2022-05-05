<?php

namespace ConsulConfigManager\Consul\Test\Feature;

use Illuminate\Support\Arr;
use ConsulConfigManager\Consul\Test\TestCase;
use ConsulConfigManager\Consul\Models\Service;
use ConsulConfigManager\Consul\Domain\Service\ServiceAggregateRoot;
use ConsulConfigManager\Consul\Domain\Service\Interfaces\ServiceEntity;

/**
 * Class ServiceTest
 * @package ConsulConfigManager\Consul\Test\Feature
 */
class ServiceTest extends TestCase
{
    /**
     * Common service UUID
     * @var string
     */
    private static $serviceUUID = '0ead0ce3-1651-446e-9935-e558ad766cae';

    public function testShouldPassIfEmptyServicesListCanBeRetrieved(): void
    {
        $response = $this->get('/consul/services');
        $response->assertStatus(200);
        $response->assertExactJson([
            'success'       =>  true,
            'code'          =>  200,
            'data'          =>  [],
            'message'       =>  'Successfully fetched list of available services',
        ]);
    }

    public function testShouldPassIfNonEmptyServicesListCanBeRetrieved(): void
    {
        $this->createAndGetService();
        $response = $this->get('/consul/services');
        $response->assertStatus(200);
        $decoded = $response->json();
        Arr::forget($decoded, 'data.0.created_at');
        Arr::forget($decoded, 'data.0.updated_at');
        ksort($decoded['data'][0]);

        $this->assertSame([
            'success'       =>  true,
            'code'          =>  200,
            'data'          =>  $this->servicesServiceResponseConfiguration(),
            'message'       =>  'Successfully fetched list of available services',
        ], $decoded);
    }

    public function testShouldPassIfServiceInformationCanBeRetrieved(): void
    {
        $this->createAndGetService();
        $response = $this->get('/consul/service/ccm-example-127.0.0.1');
        $response->assertStatus(200);
        $decoded = Arr::except($response->json('data'), [
            'created_at',
            'updated_at',
            'deleted_at',
        ]);
        ksort($decoded);
        $this->assertSame($this->serviceResponseConfiguration(), $decoded);
    }

    public function testShouldPassIfServiceInformationCannotBeRetrieved(): void
    {
        $response = $this->get('/consul/service/ccm-example-127.0.0.1');
        $response->assertStatus(404);
        $response->assertExactJson([
            'success'       =>  false,
            'code'          =>  404,
            'data'          =>  [],
            'message'       =>  'Unable to find requested service',
        ]);
    }

    /**
     * Create new service and return its model
     * @return ServiceEntity
     */
    private function createAndGetService(): ServiceEntity
    {
        ServiceAggregateRoot::retrieve(self::$serviceUUID)
            ->createEntity($this->serviceConfiguration())
            ->persist();
        return Service::uuid(self::$serviceUUID);
    }

    /**
     * Generate service configuration for create event
     * @return array
     */
    private function serviceConfiguration(): array
    {
        $service = [
            'id'                        =>  'ccm-example-127.0.0.1',
            'service'                   =>  'ccm',
            'address'                   =>  '127.0.0.1',
            'port'                      =>  32175,
            'datacenter'                =>  'dc0',
            'tags'                      =>  [],
            'meta'                      =>  [
                'operating_system'      =>  'linux',
                'log_level'             =>  'DEBUG',
                'go_version'            =>  '1.17.2',
                'environment'           =>  'development',
                'architecture'          =>  'amd64',
                'application_version'   =>  '99.9.9',
            ],
            'online'                    =>  true,
        ];
        ksort($service);
        return $service;
    }

    private function serviceResponseConfiguration(): array
    {
        $service = $this->serviceConfiguration();
        Arr::set($service, 'identifier', Arr::get($service, 'id'));
        Arr::set($service, 'id', 1);
        Arr::set($service, 'uuid', self::$serviceUUID);
        Arr::set($service, 'environment', Arr::get($service, 'meta.environment'));
        ksort($service);
        return $service;
    }

    private function servicesServiceResponseConfiguration(): array
    {
        $service = $this->serviceResponseConfiguration();
        Arr::set($service, 'version', Arr::get($service, 'meta.application_version'));
        Arr::forget($service, [
            'tags',
            'meta',
            'deleted_at',
        ]);
        ksort($service);
        return [
            $service,
        ];
    }
}
