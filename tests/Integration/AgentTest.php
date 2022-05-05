<?php

namespace ConsulConfigManager\Consul\Test\Integration;

use Consul\Exceptions\RequestException;
use ConsulConfigManager\Consul\Test\TestCase;
use ConsulConfigManager\Consul\Services\AgentService;

/**
 * Class AgentTest
 *
 * @package ConsulConfigManager\Consul\Test\Integration
 */
class AgentTest extends TestCase
{
    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromHostRequest(): void
    {
        $response = $this->service()->host();
        $this->assertArrayHasKey('memory', $response);
        $this->assertArrayHasKey('cpu', $response);
        $this->assertArrayHasKey('host', $response);
        $this->assertArrayHasKey('disk', $response);
        $this->assertArrayHasKey('collection_time', $response);
        $this->assertArrayHasKey('errors', $response);
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromMembersRequest(): void
    {
        $response = $this->service()->members();
        $this->assertNotCount(0, $response);
        foreach ($response as $member) {
            $this->assertArrayHasKey('name', $member);
            $this->assertArrayHasKey('addr', $member);
            $this->assertArrayHasKey('port', $member);
            $this->assertArrayHasKey('status', $member);
        }
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromSelfRequest(): void
    {
        $response = $this->service()->self();
        $this->assertArrayHasKey('config', $response);
        $this->assertArrayHasKey('debug_config', $response);
        $this->assertArrayHasKey('coord', $response);
        $this->assertArrayHasKey('member', $response);
        $this->assertArrayHasKey('stats', $response);
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromMetricsRequest(): void
    {
        $response = $this->service()->metrics();
        $this->assertArrayHasKey('timestamp', $response);
        $this->assertArrayHasKey('gauges', $response);
    }

    /**
     * @return void
     */
    public function testShouldPassIfCheckWasRegisteredSuccessfully(): void
    {
        $response = $this->service()->registerCheck([
            'ID'                                =>  "ping_google",
            'Name'                              =>  "Check if Google is reachable",
            'Notes'                             =>  "Ensure that we are able to reach google",
            'DeregisterCriticalServiceAfter'    =>  "90m",
            'Timeout'                           =>  '5s',
            'TLSSkipVerify'                     =>  true,
            'TTL'                               =>  '30s',
        ]);
        $this->assertTrue($response);
    }

    /**
     * @return void
     */
    public function testShouldFailIfCheckFailedToRegister(): void
    {
        $response = $this->service()->registerCheck([
            'Name'                              =>  "Memory utilization",
        ]);
        $this->assertFalse($response);
    }

    /**
     * @return void
     */
    public function testShouldPassIfSuccessfullySetPassStatusToCheck(): void
    {
        $response = $this->service()->ttlCheckPass('ping_google');
        $this->assertTrue($response);
    }

    /**
     * @return void
     */
    public function testShouldFailIfFailedToSetPassStatusToCheck(): void
    {
        $response = $this->service()->ttlCheckPass('google_ping');
        $this->assertFalse($response);
    }

    /**
     * @return void
     */
    public function testShouldPassIfSuccessfullySetWarnStatusToCheck(): void
    {
        $response = $this->service()->ttlCheckWarn('ping_google');
        $this->assertTrue($response);
    }

    /**
     * @return void
     */
    public function testShouldFailIfFailedToSetWarnStatusToCheck(): void
    {
        $response = $this->service()->ttlCheckWarn('google_ping');
        $this->assertFalse($response);
    }

    /**
     * @return void
     */
    public function testShouldPassIfSuccessfullySetFailStatusToCheck(): void
    {
        $response = $this->service()->ttlCheckFail('ping_google');
        $this->assertTrue($response);
    }

    /**
     * @return void
     */
    public function testShouldFailIfFailedToSetFailStatusToCheck(): void
    {
        $response = $this->service()->ttlCheckFail('google_ping');
        $this->assertFalse($response);
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromListChecksRequest(): void
    {
        $response = $this->service()->listChecks();
        $this->assertArrayHasKey('ping_google', $response);
    }

    /**
     * @return void
     */
    public function testShouldPassIfAbleToDeleteExistingCheck(): void
    {
        $response = $this->service()->deRegisterCheck('ping_google');
        $this->assertTrue($response);
    }

    /**
     * @return void
     */
    public function testShouldFailIfUnableToDeleteNonExistingCheck(): void
    {
        $response = $this->service()->deRegisterCheck('google_ping');
        $this->assertFalse($response);
    }

    /**
     * @return void
     */
    public function testShouldPassIfServiceWasSuccessfullyRegistered(): void
    {
        $response = $this->service()->registerService([
            'ID'            =>  'redis1',
            'Name'          =>  'redis',
            'Tags'          =>  ['primary', 'v1'],
            'Address'       =>  '127.0.0.1',
            'Port'          =>  8000,
            'Weights'       =>  [
                'Passing'   =>  10,
                'Warning'   =>  1,
            ],
        ]);
        $this->assertTrue($response);
    }

    /**
     * @return void
     */
    public function testShouldFailIfFailedToRegisterService(): void
    {
        $response = $this->service()->registerService([
            'Tags'          =>  ['primary', 'v1'],
            'Address'       =>  '127.0.0.1',
            'Port'          =>  8000,
            'Weights'       =>  [
                'Passing'   =>  10,
                'Warning'   =>  1,
            ],
        ]);
        $this->assertFalse($response);
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfValidDataIsReturnedFromServiceConfigurationRequest(): void
    {
        $response = $this->service()->serviceConfiguration('redis1');
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('service', $response);
        $this->assertArrayHasKey('content_hash', $response);
        $this->assertArrayHasKey('datacenter', $response);
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldFailIfFailedToRetrieveDataFromServiceConfigurationRequest(): void
    {
        $this->expectException(RequestException::class);
        $this->service()->serviceConfiguration('redis1001');
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfValidDataIsReturnedFromLocalServiceHealthRequest(): void
    {
        $response = $this->service()->localServiceHealth('redis');
        $this->assertNotCount(0, $response);
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfValidDataIsReturnedFromLocalServiceHealthByIdRequest(): void
    {
        $response = $this->service()->localServiceHealthByID('redis1');
        $this->assertArrayHasKey('aggregated_status', $response);
        $this->assertArrayHasKey('service', $response);
        $this->assertArrayHasKey('checks', $response);
    }

    /**
     * @throws RequestException
     * @return void
     */
    public function testShouldPassIfValidDataIsReturnedFromListServicesRequest(): void
    {
        $response = $this->service()->listServices();
        $this->assertArrayHasKey('redis1', $response);
    }

    /**
     * @return void
     */
    public function testShouldPassIfServiceSuccessfullyMovedToMaintenanceMode(): void
    {
        $response = $this->service()->toggleMaintenanceMode('redis1', true, 'Any reason');
        $this->assertTrue($response);
    }

    /**
     * @return void
     */
    public function testShouldFailIfFailedToMoveServiceToMaintenanceMode(): void
    {
        $response = $this->service()->toggleMaintenanceMode('redis1001', true, 'Any reason');
        $this->assertFalse($response);
    }

    /**
     * @return void
     */
    public function testShouldPassIfServiceWasSuccessfullyDeregistered(): void
    {
        $response = $this->service()->deregisterService('redis1');
        $this->assertTrue($response);
    }

    /**
     * @return void
     */
    public function testShouldFailIfFailedToDeregisterService(): void
    {
        $response = $this->service()->deRegisterService('redis1001');
        $this->assertFalse($response);
    }

    /**
     * Create new service instance
     * @return AgentService
     */
    private function service(): AgentService
    {
        return new AgentService();
    }
}
