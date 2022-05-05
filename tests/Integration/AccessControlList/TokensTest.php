<?php

namespace ConsulConfigManager\Consul\Test\Integration\AccessControlList;

use Illuminate\Support\Arr;
use Consul\Exceptions\RequestException;
use ConsulConfigManager\Consul\Test\TestCase;
use ConsulConfigManager\Consul\Services\AccessControlListService;

/**
 * Class TokensTest
 *
 * @package ConsulConfigManager\Consul\Test\Integration\AccessControlList
 */
class TokensTest extends TestCase
{
    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfReplicationStatusCanBeQueried(): void
    {
        $response = $this->service()->replicationStatus('dc1');
        $this->assertArrayHasKey('enabled', $response);
        $this->assertArrayHasKey('running', $response);
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfReplicationStatusCannotBeQueried(): void
    {
        $this->expectException(RequestException::class);
        $this->service()->replicationStatus('dc0');
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfRuleCanBeTranslated(): void
    {
        $response = $this->service()->translateRule('agent "" { policy = "read" }');
        $formattedResponse = str_replace("\n", '', $response);
        $this->assertEquals('agent_prefix "" {  policy = "read"}', $formattedResponse);
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfTokenCanBeCreated(): void
    {
        $parameters = [
            'AccessorID'        =>  '166ca5e7-4dea-494c-96fa-166c5ea52acc',
            'Description'       =>  'Example Token',
            'Policies'          =>  [
                [
                    'ID'        =>  '00000000-0000-0000-0000-000000000001',
                ],
            ],
            'Roles'             =>  [],
            'Local'             =>  false,
        ];
        $response = $this->service()->createToken($parameters);
        $this->assertEquals(Arr::get($parameters, 'AccessorID'), Arr::get($response, 'accessor_id'));
        $this->assertEquals(Arr::get($parameters, 'Description'), Arr::get($response, 'description'));
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfTokenCanBeUpdated(): void
    {
        $response = $this->service()->updateToken('166ca5e7-4dea-494c-96fa-166c5ea52acc', [
            'Description'       =>  'New Description',
        ]);
        $this->assertEquals('New Description', Arr::get($response, 'description'));
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfTokenCanBeDeleted(): void
    {
        $response = $this->service()->deleteToken('166ca5e7-4dea-494c-96fa-166c5ea52acc');
        $this->assertTrue($response);
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfTokenCanBeRead(): void
    {
        $response = $this->service()->readToken('00000000-0000-0000-0000-000000000002');
        $this->assertArrayHasKey('accessor_id', $response);
        $this->assertArrayHasKey('secret_id', $response);
        $this->assertArrayHasKey('local', $response);
        $this->assertArrayHasKey('create_time', $response);
        $this->assertArrayHasKey('hash', $response);
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfMyTokenCanBeRead(): void
    {
        $response = $this->service()->myToken();
        $this->assertArrayHasKey('accessor_id', $response);
        $this->assertArrayHasKey('secret_id', $response);
        $this->assertArrayHasKey('local', $response);
        $this->assertArrayHasKey('create_time', $response);
        $this->assertArrayHasKey('hash', $response);
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfTokensCanBeListed(): void
    {
        $response = $this->service()->listTokens();
        $this->assertNotCount(0, $response);
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
