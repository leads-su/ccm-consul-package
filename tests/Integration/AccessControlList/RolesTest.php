<?php

namespace ConsulConfigManager\Consul\Test\Integration\AccessControlList;

use LdapRecord\Support\Arr;
use Consul\Exceptions\RequestException;
use ConsulConfigManager\Consul\Test\TestCase;
use ConsulConfigManager\Consul\Services\AccessControlListService;

/**
 * Class RolesTest
 *
 * @package ConsulConfigManager\Consul\Test\Integration\AccessControlList
 */
class RolesTest extends TestCase
{
    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfRoleCanBeCreated(): void
    {
        $parameters = [
            'Name'          =>  'example-role',
            'Description'   =>  'Example Role',
            'Policies'      =>  [],
        ];
        $response = $this->service()->createRole($parameters);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals(Arr::get($parameters, 'Name'), Arr::get($response, 'name'));
        $this->assertEquals(Arr::get($parameters, 'Description'), Arr::get($response, 'description'));
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfRoleCanBeReadByName(): void
    {
        $response = $this->service()->readRoleByName('example-role');
        $this->assertIsArray($response);
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfRoleCanBeReadById(): void
    {
        $byNameResponse = $this->service()->readRoleByName('example-role');
        $byIdResponse = $this->service()->readRole(Arr::get($byNameResponse, 'id'));
        $this->assertEquals($byNameResponse, $byIdResponse);
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfRoleCanBeUpdated(): void
    {
        $byNameResponse = $this->service()->readRoleByName('example-role');
        $response = $this->service()->updateRole(Arr::get($byNameResponse, 'id'), [
            'Name'              =>  'example-role',
            'Description'       =>  'New Description',
        ]);
        $this->assertEquals('New Description', Arr::get($response, 'description'));
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfRolesCanBeListed(): void
    {
        $response = $this->service()->listRoles();
        $this->assertCount(1, $response);
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfRoleCanBeDeleted(): void
    {
        $byNameResponse = $this->service()->readRoleByName('example-role');
        $response = $this->service()->deleteRole(Arr::get($byNameResponse, 'id'));
        $this->assertTrue($response);
    }

    /**
     * Create new service instance
     * @return AccessControlListService
     */
    private function service(): AccessControlListService
    {
        return new AccessControlListService();
    }
}
