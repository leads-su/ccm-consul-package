<?php

namespace ConsulConfigManager\Consul\Test\Unit\Models;

use Illuminate\Support\Arr;
use ConsulConfigManager\Consul\Test\TestCase;
use ConsulConfigManager\Consul\Models\KeyValue;
use ConsulConfigManager\Consul\Domain\KeyValue\Interfaces\KeyValueEntity;

/**
 * Class KeyValueTest
 *
 * @package ConsulConfigManager\Consul\Test\Unit\Models
 */
class KeyValueTest extends TestCase
{
    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromGetIdMethod(array $attributes): void
    {
        $response = $this->model($attributes)->getID();
        $this->assertEquals(Arr::get($attributes, 'id'), $response);
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromSetIdMethod(array $attributes): void
    {
        $model = $this->model($attributes);
        $model->setID(2);
        $this->assertEquals(2, $model->getID());
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromGetUuidMethod(array $attributes): void
    {
        $response = $this->model($attributes)->getUuid();
        $this->assertEquals(Arr::get($attributes, 'uuid'), $response);
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromSetUuidMethod(array $attributes): void
    {
        $model = $this->model($attributes);
        $model->setUuid('f972db4f-52de-4bf3-ba00-6343735d4abc');
        $this->assertEquals('f972db4f-52de-4bf3-ba00-6343735d4abc', $model->getUuid());
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromGetPathMethod(array $attributes): void
    {
        $response = $this->model($attributes)->getPath();
        $this->assertEquals(Arr::get($attributes, 'path'), $response);
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromSetPathMethod(array $attributes): void
    {
        $model = $this->model($attributes);
        $model->setPath('consul/set_path');
        $this->assertEquals('consul/set_path', $model->getPath());
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromGetValueMethod(array $attributes): void
    {
        $response = $this->model($attributes)->getValue();
        $this->assertEquals(Arr::get($attributes, 'value'), $response);
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromSetValueMethod(array $attributes): void
    {
        $model = $this->model($attributes);
        $model->setValue(['type' => 'string', 'value' => 'string']);
        $this->assertEquals(['type' => 'string', 'value' => 'string'], $model->getValue());
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromIsReferenceMethod(array $attributes): void
    {
        $response = $this->model($attributes)->isReference();
        $this->assertEquals(false, $response);
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromMarkAsReferenceMethod(array $attributes): void
    {
        $model = $this->model($attributes);
        $model->markAsReference();
        $this->assertEquals(true, $model->isReference());
    }

    /**
     * Created event data provider
     * @return \array[][]
     */
    public function modelDataProvider(): array
    {
        return [
            'consul/example'            =>  [
                'data'                  =>  [
                    'id'                =>  1,
                    'uuid'              =>  'f972db4f-52de-4bf3-ba00-6343735d4efb',
                    'path'              =>  'consul/example',
                    'value'             =>  [
                        'type'          => 'string',
                        'value'         => 'Hello World',
                    ],
                ],
            ],
        ];
    }

    /**
     * Create model instance
     * @param array $attributes
     *
     * @return KeyValueEntity
     */
    private function model(array $attributes): KeyValueEntity
    {
        return KeyValue::factory()->make($attributes);
    }
}
