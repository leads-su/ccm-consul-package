<?php

namespace ConsulConfigManager\Consul\Test\Feature;

use Illuminate\Support\Arr;
use ConsulConfigManager\Consul\Test\TestCase;
use ConsulConfigManager\Consul\Models\KeyValue;
use ConsulConfigManager\Consul\Domain\KeyValue\KeyValueAggregateRoot;
use ConsulConfigManager\Consul\Domain\KeyValue\Interfaces\KeyValueEntity;

/**
 * Class KeyValueTest
 * @package ConsulConfigManager\Consul\Test\Feature
 */
class KeyValueTest extends TestCase
{
    /**
     * Common kv uuid
     * @var string
     */
    private static string $uuid = '1ead0ce3-1651-446e-9935-e558ad766cae';

    public function testShouldPassIfEmptyKeyValuesNamespacedListCanBeRetrieved(): void
    {
        $response = $this->get('/consul/kv/namespaced');
        $response->assertStatus(200);
        $response->assertExactJson([
            'success'       =>  true,
            'code'          =>  200,
            'data'          =>  [],
            'message'       =>  'Successfully fetched namespaced keys',
        ]);
    }

    public function testShouldPassIfEmptyKeyValuesReferencesListCanBeRetrieved(): void
    {
        $response = $this->get('/consul/kv/references');
        $response->assertStatus(200);
        $response->assertExactJson([
            'success'       =>  true,
            'code'          =>  200,
            'data'          =>  [],
            'message'       =>  'Successfully fetched list of references',
        ]);
    }

    public function testShouldPassIfNonEmptyKeyValuesNamespacedListCanBeRetrieved(): void
    {
        $this->createAndGetKeyValue();
        $response = $this->get('/consul/kv/namespaced');
        $response->assertStatus(200);
        $response->assertExactJson([
            'success'           =>  true,
            'code'              =>  200,
            'data'              =>  [
                'example'       =>  [
                    'example/test',
                ],
            ],
            'message'           =>  'Successfully fetched namespaced keys',
        ]);
    }

    public function testShouldPassIfNonEmptyKeyValuesReferencesListCanBeRetrieved(): void
    {
        $this->createAndGetKeyValue(true);
        $response = $this->get('/consul/kv/references');
        $response->assertStatus(200);
        $response->assertExactJson([
            'success'           =>  true,
            'code'              =>  200,
            'data'              =>  [
                [
                    'description'   =>  'Hello World!',
                    'text'          =>  'example/test',
                    'value'         =>  'example/test',
                ],
            ],
            'message'           =>  'Successfully fetched list of references',
        ]);
    }

    public function testShouldPassIfKeyValueInformationCanBeRetrieved(): void
    {
        $this->createAndGetKeyValue();
        $response = $this->get('/consul/kv/read?key=example/test');
        $response->assertStatus(200);
        $decoded = Arr::except($response->json('data'), [
            'created_at',
            'updated_at',
            'deleted_at',
        ]);
        ksort($decoded);
        $this->assertSame([
            'id'        =>  1,
            'path'      =>  'example/test',
            'reference' =>  false,
            'uuid'      =>  self::$uuid,
            'value'     =>  [
                'type'  =>  'string',
                'value' =>  'Hello World!',
            ],
        ], $decoded);
    }

    public function testShouldPassIfKeyValueInformationCannotBeRetrieved(): void
    {
        $response = $this->get('/consul/kv/read?key=example/test2');
        $response->assertStatus(404);
    }

    /**
     * Create new key value and return its model
     * @param bool $asReference
     * @return KeyValueEntity
     */
    private function createAndGetKeyValue(bool $asReference = false): KeyValueEntity
    {
        KeyValueAggregateRoot::retrieve(self::$uuid)
            ->createEntity('example/test', [
                'type'          =>  'string',
                'value'         =>  'Hello World!',
            ])
            ->persist();
        if ($asReference) {
            $uuid = str_replace('cae', 'bae', self::$uuid);

            KeyValueAggregateRoot::retrieve($uuid)
                ->createEntity('example/test_reference', [
                    'type'          =>  'reference',
                    'value'         =>  'example/test',
                ])
                ->persist();

            return KeyValue::uuid($uuid);
        }
        return KeyValue::uuid(self::$uuid);
    }
}
