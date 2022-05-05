<?php

namespace ConsulConfigManager\Consul\Test\Integration;

use JsonException;
use Consul\Exceptions\RequestException;
use ConsulConfigManager\Consul\Test\TestCase;
use ConsulConfigManager\Consul\Services\KeyValueService;
use ConsulConfigManager\Consul\Exceptions\KeyValueAlreadyExistsException;
use ConsulConfigManager\Consul\Exceptions\KeyValueDoesNotExistsException;

/**
 * Class KeyValueTest
 *
 * @package ConsulConfigManager\Consul\Test\Integration
 */
class KeyValueTest extends TestCase
{
    /**
     * @throws KeyValueAlreadyExistsException
     * @throws RequestException
     * @throws JsonException
     * @return void
     */
    public function testShouldPassIfCanCreateValueWhichDoesNotExists(): void
    {
        $response = $this->service()->createKeyValue('consul/test', [
            'type'      =>  'string',
            'value'     =>  'Hello World!',
        ]);
        $this->assertTrue($response);
    }

    /**
     * @throws JsonException
     * @throws KeyValueAlreadyExistsException
     * @throws RequestException
     * @return void
     */
    public function testShouldFailIfTryingToCreateValueWhichAlreadyExists(): void
    {
        $this->expectException(KeyValueAlreadyExistsException::class);
        $this->service()->createKeyValue('consul/test', [
            'type'  =>  'string',
            'value' =>  'Hello World!',
        ]);
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfCanRetrieveValueOfKeyWhichExists(): void
    {
        $response = $this->service()->getKeyValue('consul/test');
        $this->assertEquals([
            'type'  =>  'string',
            'value' =>  'Hello World!',
        ], $response);
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfCanRetrieveValuesOfKeysInPrefix(): void
    {
        $response = $this->service()->getKeysValuesInPrefix('consul/');
        $this->assertArrayHasKey('consul/test', $response);
        $this->assertEquals([
            'type'      =>  'string',
            'value'     =>  'Hello World!',
        ], $response['consul/test']);
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfCanRetrieveKeysList(): void
    {
        $response = $this->service()->getKeysList('consul/');
        $this->assertContains('consul/test', $response);
    }

    /**
     * @throws JsonException
     * @throws KeyValueDoesNotExistsException
     * @return void
     */
    public function testShouldPassIfCanUpdateValueWhichAlreadyExists(): void
    {
        $response = $this->service()->updateKeyValue('consul/test', [
            'type'  =>  'string',
            'value' =>  'Hello new world!',
        ]);
        $this->assertTrue($response);
    }

    /**
     * @throws JsonException
     * @throws KeyValueDoesNotExistsException
     * @return void
     */
    public function testShouldFailIfCannotUpdateValueWhichDoesNotExists(): void
    {
        $this->expectException(KeyValueDoesNotExistsException::class);
        $this->service()->updateKeyValue('consul/missing-test', [
            'type'  =>  'string',
            'value' =>  'Hello new world!',
        ]);
    }

    /**
     * @throws JsonException
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfCanCreateOrUpdateValue(): void
    {
        $response = $this->service()->createOrUpdateKeyValue('consul/test', [
            'type'  =>  'string',
            'value' =>  'Hello new new world!',
        ]);
        $this->assertTrue($response);
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfCanDeleteExistingKey(): void
    {
        $response = $this->service()->deleteKey('consul/test');
        $this->assertTrue($response);
    }

    /**
     * Create new instance of service
     * @return KeyValueService
     */
    private function service(): KeyValueService
    {
        return new KeyValueService();
    }
}
