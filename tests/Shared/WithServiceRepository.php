<?php

namespace ConsulConfigManager\Consul\Test\Shared;

use Mockery;
use Mockery\MockInterface;
use Illuminate\Foundation\Application;
use ConsulConfigManager\Consul\Models\Service;
use ConsulConfigManager\Consul\Domain\Service\Interfaces\ServiceEntity;
use ConsulConfigManager\Consul\Domain\Service\Repositories\ServiceRepository;
use ConsulConfigManager\Consul\Domain\Service\Repositories\ServiceRepositoryInterface;

/**
 * Trait WithServiceRepository
 * @package ConsulConfigManager\Consul\Test\Shared
 * @property Application $app
 */
trait WithServiceRepository
{
    /**
     * Array of Service entries
     * @var array
     */
    private array $serviceEntries = [
        [
            'id'                        =>  1,
            'uuid'                      =>  'aa52111e-751a-4ca2-a63e-01acdce449c5',
            'identifier'                =>  'ccm-example-127.0.0.1',
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
            'environment'               =>  'development',
        ],
        [
            'id'                        =>  2,
            'uuid'                      =>  'aa52111e-751a-4ca2-a63e-01bawdf449c5',
            'identifier'                =>  'ccm-example-127.0.0.2',
            'service'                   =>  'ccm',
            'address'                   =>  '127.0.0.2',
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
            'environment'               =>  'development',
        ],
        [
            'id'                        =>  3,
            'uuid'                      =>  'bb52111e-751a-4ca2-a63e-01acdce449c5',
            'identifier'                =>  'ccm-example-127.0.0.3',
            'service'                   =>  'ccm',
            'address'                   =>  '127.0.0.3',
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
            'environment'               =>  'development',
        ],
    ];

    /**
     * Repository mock instance
     * @var MockInterface
     */
    private MockInterface $serviceRepositoryMock;

    /**
     * Create bootstrapped instance of ServiceRepository
     * @param bool $withData
     * @param bool $mock
     * @return ServiceRepository
     */
    protected function serviceRepository(bool $withData = false, bool $mock = false): ServiceRepository
    {
        if ($withData) {
            foreach ($this->serviceEntries as $entry) {
                Service::create($entry);
            }
        }

        if (!$mock) {
            return $this->app->make(ServiceRepositoryInterface::class);
        }

        $this->serviceRepositoryMock = Mockery::mock(ServiceRepository::class);

        $this
            ->serviceBootstrapCreateMethod()
            ->serviceBootstrapUpdateMethod()
            ->serviceBootstrapDeleteMethod();

        return $this->serviceRepositoryMock;
    }

    private function serviceBootstrapCreateMethod(): self
    {
        $this->serviceRepositoryMock
            ->shouldReceive('create')
            ->withArgs(function (array $configuration) {
                return true;
            })->andReturnUsing(function (array $configuration): ServiceEntity {
                return $this->createServiceEntityFromArray($configuration);
            });
        return $this;
    }

    private function serviceBootstrapUpdateMethod(): self
    {
        $this->serviceRepositoryMock
            ->shouldReceive('update')
            ->withArgs(function (array $configuration) {
                return true;
            })->andReturnUsing(function (array $configuration): ServiceEntity {
                return $this->createServiceEntityFromArray($configuration);
            });
        return $this;
    }

    private function serviceBootstrapDeleteMethod(): self
    {
        $this->serviceRepositoryMock
            ->shouldReceive('delete')
            ->withArgs(function () {
                return true;
            })->andReturnUsing(function (): bool {
                return true;
            });
        return $this;
    }

    /**
     * Create service entity from provided array
     * @param array $data
     * @return ServiceEntity
     */
    private function createServiceEntityFromArray(array $data): ServiceEntity
    {
        return Service::factory()->make($data);
    }
}
