<?php

namespace ConsulConfigManager\Consul\Test\Unit\Models;

use Illuminate\Support\Arr;
use ConsulConfigManager\Consul\Test\TestCase;
use ConsulConfigManager\Consul\Models\Service;
use ConsulConfigManager\Consul\Domain\Service\Interfaces\ServiceEntity;

/**
 * Class ServiceTest
 * @package ConsulConfigManager\Consul\Test\Unit\Models
 */
class ServiceTest extends TestCase
{
    /**
     * @param array $attributes
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
    public function testShouldPassIfValidDataReturnedFromGetIdentifierMethod(array $attributes): void
    {
        $response = $this->model($attributes)->getIdentifier();
        $this->assertEquals(Arr::get($attributes, 'identifier'), $response);
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromSetIdentifierMethod(array $attributes): void
    {
        $model = $this->model($attributes);
        $model->setIdentifier('ccm-example-127.0.0.2');
        $this->assertEquals('ccm-example-127.0.0.2', $model->getIdentifier());
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromGetServiceMethod(array $attributes): void
    {
        $response = $this->model($attributes)->getService();
        $this->assertEquals(Arr::get($attributes, 'service'), $response);
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromSetServiceMethod(array $attributes): void
    {
        $model = $this->model($attributes);
        $model->setService('ccm2');
        $this->assertEquals('ccm2', $model->getService());
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromGetAddressMethod(array $attributes): void
    {
        $response = $this->model($attributes)->getAddress();
        $this->assertEquals(Arr::get($attributes, 'address'), $response);
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromSetAddressMethod(array $attributes): void
    {
        $model = $this->model($attributes);
        $model->setAddress('127.0.0.2');
        $this->assertEquals('127.0.0.2', $model->getAddress());
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromGetPortMethod(array $attributes): void
    {
        $response = $this->model($attributes)->getPort();
        $this->assertEquals(Arr::get($attributes, 'port'), $response);
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromSetPortMethod(array $attributes): void
    {
        $model = $this->model($attributes);
        $model->setPort(1234);
        $this->assertEquals(1234, $model->getPort());
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromGetDatacenterMethod(array $attributes): void
    {
        $response = $this->model($attributes)->getDatacenter();
        $this->assertEquals(Arr::get($attributes, 'datacenter'), $response);
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromSetDatacenterMethod(array $attributes): void
    {
        $model = $this->model($attributes);
        $model->setDatacenter('dc1');
        $this->assertEquals('dc1', $model->getDatacenter());
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromGetTagsMethod(array $attributes): void
    {
        $response = $this->model($attributes)->getTags();
        $this->assertEquals(Arr::get($attributes, 'tags'), $response);
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromSetTagsMethod(array $attributes): void
    {
        $model = $this->model($attributes);
        $model->setTags(['hello-world']);
        $this->assertEquals(['hello-world'], $model->getTags());
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromGetMetaMethod(array $attributes): void
    {
        $response = $this->model($attributes)->getMeta();
        $this->assertEquals(Arr::get($attributes, 'meta'), $response);
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromSetMetaMethod(array $attributes): void
    {
        $model = $this->model($attributes);
        $model->setMeta(['hello' => 'world']);
        $this->assertEquals(['hello' => 'world'], $model->getMeta());
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromIsOnlineMethod(array $attributes): void
    {
        $response = $this->model($attributes)->isOnline();
        $this->assertEquals(Arr::get($attributes, 'online'), $response);
    }

    /**
     * @param array $attributes
     *
     * @dataProvider modelDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromSetOnlineMethod(array $attributes): void
    {
        $model = $this->model($attributes);
        $model->setOnline(false);
        $this->assertEquals(false, $model->isOnline());
    }

    /**
     * Create service data provider
     * @return \array[][]
     */
    public function modelDataProvider(): array
    {
        return [
            'ccm-example-127.0.0.1'             =>  [
                'data'                          =>  [
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
            ],
        ];
    }

    /**
     * Create model instance
     * @param array $attributes
     * @return ServiceEntity
     */
    private function model(array $attributes): ServiceEntity
    {
        return Service::factory()->make($attributes);
    }
}
