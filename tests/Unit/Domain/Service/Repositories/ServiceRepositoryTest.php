<?php

namespace ConsulConfigManager\Consul\Test\Unit\Domain\Service\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;
use ConsulConfigManager\Consul\Test\TestCase;
use ConsulConfigManager\Consul\Models\Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use ConsulConfigManager\Consul\Test\Shared\WithServiceRepository;

/**
 * Class ServiceRepositoryTest
 * @package ConsulConfigManager\Consul\Test\Unit\Domain\Service\Repositories
 */
class ServiceRepositoryTest extends TestCase
{
    use WithServiceRepository;

    /**
     * @return void
     */
    public function testShouldPassIfCanCreateNewEntry(): void
    {
        $configuration = [
            'id'                        =>  4,
            'uuid'                      =>  'bb52111e-751a-4ca2-a63e-01acdce449c5',
            'identifier'                =>  'ccm-example-127.0.0.4',
            'service'                   =>  'ccm',
            'address'                   =>  '127.0.0.4',
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
        ];

        $response = $this->serviceRepository(mock: true)->create($configuration);
        $this->assertArrayHasKey('uuid', $response);
        $this->assertEquals(Arr::get($configuration, 'identifier'), $response->getIdentifier());
        $this->assertEquals(Arr::get($configuration, 'service'), $response->getService());
        $this->assertEquals(Arr::get($configuration, 'address'), $response->getAddress());
        $this->assertEquals(Arr::get($configuration, 'port'), $response->getPort());
        $this->assertEquals(Arr::get($configuration, 'datacenter'), $response->getDatacenter());
        $this->assertEquals(Arr::get($configuration, 'tags'), $response->getTags());
        $this->assertEquals(Arr::get($configuration, 'meta'), $response->getMeta());
        $this->assertEquals(Arr::get($configuration, 'online'), $response->isOnline());
        $this->assertEquals(Arr::get($configuration, 'environment'), $response->getEnvironment());
    }

    /**
     * @return void
     */
    public function testShouldPassIfCanUpdateExistingEntry(): void
    {
        $configuration = [
            'id'                        =>  4,
            'uuid'                      =>  'bb52111e-751a-4ca2-a63e-01acdce449c5',
            'identifier'                =>  'ccm-example-127.0.0.4',
            'service'                   =>  'ccm',
            'address'                   =>  '127.0.0.4',
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
        ];

        $response = $this->serviceRepository(mock: true)->update($configuration);
        $this->assertArrayHasKey('uuid', $response);
        $this->assertEquals(Arr::get($configuration, 'identifier'), $response->getIdentifier());
        $this->assertEquals(Arr::get($configuration, 'service'), $response->getService());
        $this->assertEquals(Arr::get($configuration, 'address'), $response->getAddress());
        $this->assertEquals(Arr::get($configuration, 'port'), $response->getPort());
        $this->assertEquals(Arr::get($configuration, 'datacenter'), $response->getDatacenter());
        $this->assertEquals(Arr::get($configuration, 'tags'), $response->getTags());
        $this->assertEquals(Arr::get($configuration, 'meta'), $response->getMeta());
        $this->assertEquals(Arr::get($configuration, 'online'), $response->isOnline());
        $this->assertEquals(Arr::get($configuration, 'environment'), $response->getEnvironment());
    }

    /**
     * @return void
     */
    public function testShouldPassIfCanDeleteExistingEntry(): void
    {
        $response = $this->serviceRepository(withData: true, mock: true)->delete('ccm-example-127.0.0.4');
        $this->assertTrue($response);
    }

    /**
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromAllRequest(): void
    {
        $response = $this->serviceRepository(true)->all();
        $this->assertEquals(
            $this->exceptDates($this->serviceEntries, true),
            $this->exceptDates($response, true)
        );
    }

    /**
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromFindRequest(): void
    {
        $response = $this->serviceRepository(true)->find('ccm-example-127.0.0.1');
        $this->assertEquals(
            $this->exceptDates($this->createServiceEntityFromArray(Arr::first($this->serviceEntries))),
            $this->exceptDates($response)
        );
    }

    /**
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromFindOrFailRequest(): void
    {
        $response = $this->serviceRepository(true)->findOrFail('ccm-example-127.0.0.1');
        $this->assertEquals(
            $this->exceptDates($this->createServiceEntityFromArray(Arr::first($this->serviceEntries))),
            $this->exceptDates($response)
        );
    }

    /**
     * @return void
     */
    public function testShouldPassIfExceptionIsThrownOnModelNotFoundFromFindOrFailRequest(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->serviceRepository(true)->findOrFail('12345678');
    }

    /**
     * Create array without dates from entity
     *
     * @param array|Service|Collection $entity
     * @param bool                     $nested
     *
     * @return array
     */
    private function exceptDates(array|Service|Collection $entity, bool $nested = false): array
    {
        if (!is_array($entity)) {
            $entity = $entity->toArray();
        }

        if ($nested) {
            $data = [];
            foreach ($entity as $index => $value) {
                $data[$index] = Arr::except($value, [
                    'created_at',
                    'updated_at',
                    'deleted_at',
                ]);
            }
            return $data;
        }

        return Arr::except($entity, [
            'created_at',
            'updated_at',
            'deleted_at',
        ]);
    }
}
