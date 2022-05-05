<?php

namespace ConsulConfigManager\Consul\Test\Shared;

use Mockery;
use Mockery\MockInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Foundation\Application;
use ConsulConfigManager\Consul\Models\KeyValue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use ConsulConfigManager\Consul\Domain\KeyValue\Interfaces\KeyValueEntity;
use ConsulConfigManager\Consul\Domain\KeyValue\Repositories\KeyValueRepository;
use ConsulConfigManager\Consul\Domain\KeyValue\Repositories\KeyValueRepositoryInterface;

/**
 * Trait WithKeyValueRepository
 *
 * @package ConsulConfigManager\Consul\Test\Shared
 * @property Application $app
 */
trait WithKeyValueRepository
{
    /**
     * Array of KeyValue entries
     * @var array|array[]
     */
    private array $keyValueEntries = [
        [
            'id'            =>  1,
            'uuid'          =>  'c1d4a6f6-ee86-481b-96ef-0a364fb9d26d',
            'path'          =>  'consul/example_one',
            'value'         =>  [
                'type'      =>  'string',
                'value'     =>  'Hello World One!',
            ],
            'reference'     =>  false,
            'created_at'    =>  1630914000,
            'updated_at'    =>  1630914000,
            'deleted_at'    =>  null,
        ],
        [
            'id'            =>  2,
            'uuid'          =>  '0733984d-9c6c-4f7e-b7a6-7c3022ac014d',
            'path'          =>  'consul/example_two',
            'value'         =>  [
                'type'      =>  'string',
                'value'     =>  'Hello World Two!',
            ],
            'reference'     =>  false,
            'created_at'    =>  1630914300,
            'updated_at'    =>  1630914300,
            'deleted_at'    =>  null,
        ],
        [
            'id'            =>  3,
            'uuid'          =>  '1a1cfbed-2f7b-476c-8a65-011068c79ba5',
            'path'          =>  'consul/example_three',
            'value'         =>  [
                'type'      =>  'string',
                'value'     =>  'Hello World Three!',
            ],
            'reference'     =>  false,
            'created_at'    =>  1630914600,
            'updated_at'    =>  1630914600,
            'deleted_at'    =>  null,
        ],
    ];

    /**
     * Repository mock instance
     * @var MockInterface
     */
    private MockInterface $keyValueRepositoryMock;

    /**
     * Creates bootstrapped instance of KeyValueRepository
     *
     * @param bool $withData
     * @param bool $mock
     *
     * @return KeyValueRepository
     */
    protected function keyValueRepository(bool $withData = false, bool $mock = false): KeyValueRepository
    {
        if ($withData) {
            foreach ($this->keyValueEntries as $entry) {
                KeyValue::create($entry);
            }
        }

        if (!$mock) {
            return $this->app->make(KeyValueRepositoryInterface::class);
        }

        $this->keyValueRepositoryMock = Mockery::mock(KeyValueRepository::class);

        $this
            ->keyValueBootstrapCreateMethod()
            ->keyValueBootstrapUpdateMethod()
            ->keyValueBootstrapDeleteMethod();

        return $this->keyValueRepositoryMock;
    }

    /**
     * Ensure that repository is able to respond to `create` method request
     * @return static|self|$this
     */
    private function keyValueBootstrapCreateMethod(): self
    {
        $this->keyValueRepositoryMock
            ->shouldReceive('create')
            ->withArgs(function (string $path, array $value) {
                return true;
            })
            ->andReturnUsing(function (string $path, array $value): KeyValueEntity {
                return $this->createKeyValueEntityFromArray([
                    'id'            =>  4,
                    'uuid'          =>  Str::uuid()->toString(),
                    'path'          =>  $path,
                    'value'         =>  $value,
                    'reference'     =>  Arr::get($value, 'type') === 'reference',
                    'created_at'    =>  time(),
                    'updated_at'    =>  time(),
                    'deleted_at'    =>  null,
                ]);
            });
        return $this;
    }

    /**
     * Ensure that repository is able to respond to `update` method request
     * @return static|self|$this
     */
    private function keyValueBootstrapUpdateMethod(): self
    {
        $this->keyValueRepositoryMock
            ->shouldReceive('update')
            ->withArgs(function (string $path, array $value) {
                return true;
            })
            ->andReturnUsing(function (string $path, array $value): KeyValueEntity {
                return $this->createKeyValueEntityFromArray([
                    'path'          =>  $path,
                    'value'         =>  $value,
                    'reference'     =>  Arr::get($value, 'type') === 'reference',
                ]);
            });
        return $this;
    }

    /**
     * Ensure that repository is able to respond to `delete` method request
     * @return static|self|$this
     */
    private function keyValueBootstrapDeleteMethod(): self
    {
        $this->keyValueRepositoryMock
            ->shouldReceive('delete')
            ->withArgs(function (string $path, bool $forceDelete = false) {
                return true;
            })
            ->andReturnUsing(function (string $path, bool $forceDelete = false): bool {
                return true;
            });
        return $this;
    }



    /**
     * Create key value entity from provided array
     * @param array $data
     *
     * @return KeyValueEntity
     */
    private function createKeyValueEntityFromArray(array $data): KeyValueEntity
    {
        return KeyValue::factory()->make($data);
    }

    /**
     * Shared implementation for `find` and `findOrFail` methods
     *
     * @param string $path
     * @param array  $columns
     * @param bool   $fail
     *
     * @return KeyValueEntity|null
     */
    private function keyValueRepositoryFindFindOrFailImplementation(string $path, array $columns = ['*'], bool $fail = false): ?KeyValueEntity
    {
        $keyValue = null;

        foreach ($this->keyValueEntries as $entry) {
            if (Arr::get($entry, 'path') === $path) {
                $keyValue = $entry;
                break;
            }
        }

        if (!$keyValue) {
            if ($fail) {
                throw new ModelNotFoundException();
            }
            return null;
        }

        if (!in_array('*', $columns, true)) {
            $keyValue = Arr::only($keyValue, $columns);
        }

        return $this->createKeyValueEntityFromArray($keyValue);
    }
}
