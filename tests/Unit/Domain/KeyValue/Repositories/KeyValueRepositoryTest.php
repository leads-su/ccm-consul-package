<?php

namespace ConsulConfigManager\Consul\Test\Unit\Domain\KeyValue\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;
use ConsulConfigManager\Consul\Test\TestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use ConsulConfigManager\Consul\Test\Shared\WithKeyValueRepository;
use ConsulConfigManager\Consul\Domain\KeyValue\Interfaces\KeyValueEntity;

/**
 * Class KeyValueRepositoryTest
 *
 * @package ConsulConfigManager\Consul\Test\Unit\Domain\KeyValue\Repositories
 */
class KeyValueRepositoryTest extends TestCase
{
    use WithKeyValueRepository;

    /**
     * @return void
     */
    public function testShouldPassIfCanCreateNewEntry(): void
    {
        $path = 'consul/example_four';
        $value = [
            'type'  =>  'string',
            'value' =>  'Hello World Four!',
        ];

        $response = $this->keyValueRepository(mock: true)->create($path, $value);
        $this->assertArrayHasKey('uuid', $response);
        $this->assertEquals($path, $response->getPath());
        $this->assertEquals($value, $response->getValue());
    }

    /**
     * @return void
     */
    public function testShouldPassIfCanUpdateExistingEntry(): void
    {
        $path = 'consul/example_four';
        $value = [
            'type'  =>  'string',
            'value' =>  'Hello World Four!',
        ];

        $response = $this->keyValueRepository(mock: true)->update($path, $value);
        $this->assertArrayHasKey('uuid', $response);
        $this->assertEquals($path, $response->getPath());
        $this->assertEquals($value, $response->getValue());
    }

    /**
     * @return void
     */
    public function testShouldPassIfCanDeleteExistingEntry(): void
    {
        $response = $this->keyValueRepository(withData: true, mock: true)->delete('consul/example_four', false);
        $this->assertTrue($response);
    }

    /**
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromAllRequest(): void
    {
        $response = $this->keyValueRepository(true)->all();
        $this->assertEquals(
            $this->exceptDates($this->keyValueEntries, true),
            $this->exceptDates($response, true)
        );
    }

    /**
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromAllKeysRequest(): void
    {
        $response = $this->keyValueRepository(true)->allKeys();
        $this->assertEquals([
            'consul/example_one',
            'consul/example_two',
            'consul/example_three',
        ], $response);
    }

    /**
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromAllNamespacedRequest(): void
    {
        $response = $this->keyValueRepository(true)->allNamespaced();
        $this->assertEquals([
            'consul'    =>  [
                'consul/example_one',
                'consul/example_two',
                'consul/example_three',
            ],
        ], $response);
    }

    /**
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromFindRequest(): void
    {
        $response = $this->keyValueRepository(true)->find('consul/example_one');
        $this->assertEquals(
            $this->exceptDates($this->createKeyValueEntityFromArray(Arr::first($this->keyValueEntries))),
            $this->exceptDates($response)
        );
    }

    /**
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromFindOrFailRequest(): void
    {
        $response = $this->keyValueRepository(true)->findOrFail('consul/example_one');
        $this->assertEquals(
            $this->exceptDates($this->createKeyValueEntityFromArray(Arr::first($this->keyValueEntries))),
            $this->exceptDates($response)
        );
    }

    /**
     * @return void
     */
    public function testShouldPassIfExceptionIsThrownOnModelNotFoundFromFindOrFailRequest(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->keyValueRepository(true)->findOrFail('consul/example_hundred_and_one');
    }

    /**
     * Create array without dates from entity
     *
     * @param array|KeyValueEntity|Collection $entity
     * @param bool                            $nested
     *
     * @return array
     */
    private function exceptDates(array|KeyValueEntity|Collection $entity, bool $nested = false): array
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
