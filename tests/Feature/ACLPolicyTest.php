<?php

namespace ConsulConfigManager\Consul\Test\Feature;

use Illuminate\Support\Arr;
use ConsulConfigManager\Consul\Models\Policy;
use ConsulConfigManager\Consul\Test\TestCase;
use ConsulConfigManager\Consul\Domain\ACL\Policy\ACLPolicyAggregateRoot;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Interfaces\ACLPolicyEntity;

/**
 * Class ACLPolicyTest
 * @package ConsulConfigManager\Consul\Test\Feature
 */
class ACLPolicyTest extends TestCase
{
    /**
     * Common UUID
     * @var string
     */
    private static $uuid = '0ead0ce3-1651-446e-9935-e558ad766eac';

    public function testShouldPassIfEmptyPoliciesListCanBeRetrieved(): void
    {
        $response = $this->get('/consul/acl/policies');
        $response->assertStatus(200);
        $response->assertExactJson([
            'success'       =>  true,
            'code'          =>  200,
            'data'          =>  [],
            'message'       =>  'Successfully fetched list of policies',
        ]);
    }

    public function testShouldPassIfNonEmptyPoliciesListCanBeRetrieved(): void
    {
        $this->createAndGetPolicy();
        $response = $this->get('/consul/acl/policies');
        $response->assertStatus(200);
        $decoded = $response->json();
        Arr::forget($decoded, 'data.0.created_at');
        Arr::forget($decoded, 'data.0.updated_at');
        ksort($decoded['data'][0]);

        $this->assertSame([
            'success'       =>  true,
            'code'          =>  200,
            'data'          =>  $this->policiesListResponse(),
            'message'       =>  'Successfully fetched list of policies',
        ], $decoded);
    }

    public function testShouldPassIfPolicyCanBeRetrievedWithId(): void
    {
        $this->createAndGetPolicy();
        $shouldMatch = $this->policyResponse();
        $response = $this->get('/consul/acl/policies/' . Arr::get($shouldMatch, 'id'));
        $response->assertStatus(200);

        $decoded = $response->json();
        Arr::forget($decoded, 'data.created_at');
        Arr::forget($decoded, 'data.updated_at');
        Arr::forget($decoded, 'data.deleted_at');
        ksort($decoded['data']);

        $this->assertSame([
            'success'       =>  true,
            'code'          =>  200,
            'data'          =>  $shouldMatch,
            'message'       =>  'Successfully fetched policy information',
        ], $decoded);
    }

    public function testShouldPassIfPolicyCanBeRetrievedWithUuid(): void
    {
        $this->createAndGetPolicy();
        $shouldMatch = $this->policyResponse();
        $response = $this->get('/consul/acl/policies/' . self::$uuid);
        $response->assertStatus(200);

        $decoded = $response->json();
        Arr::forget($decoded, 'data.created_at');
        Arr::forget($decoded, 'data.updated_at');
        Arr::forget($decoded, 'data.deleted_at');
        ksort($decoded['data']);

        $this->assertSame([
            'success'       =>  true,
            'code'          =>  200,
            'data'          =>  $shouldMatch,
            'message'       =>  'Successfully fetched policy information',
        ], $decoded);
    }

    /**
     * Create new service and return its model
     * @return ACLPolicyEntity
     */
    private function createAndGetPolicy(): ACLPolicyEntity
    {
        $configuration = $this->policyConfiguration();
        ACLPolicyAggregateRoot::retrieve(self::$uuid)
            ->createEntity(
                Arr::get($configuration, 'id'),
                Arr::get($configuration, 'name'),
                Arr::get($configuration, 'description'),
                Arr::get($configuration, 'rules'),
            )
            ->persist();
        return Policy::uuid(self::$uuid);
    }

    /**
     * Create policy configuration
     * @return string[]
     */
    private function policyConfiguration(): array
    {
        $configuration = [
            'id'            =>  '1e8f8bb7-0111-450a-3f05-56d4e3911bb9',
            'name'          =>  'example_policy',
            'description'   =>  'This is an example policy.',
            'rules'         =>  '',
        ];
        ksort($configuration);
        return $configuration;
    }

    /**
     * Create policy response
     * @return string[]
     */
    private function policyResponse(): array
    {
        $policy = $this->policyConfiguration();
        Arr::set($policy, 'uuid', self::$uuid);

        ksort($policy);
        return $policy;
    }

    /**
     * Create policies response
     * @return array
     */
    private function policiesListResponse(): array
    {
        $service = $this->policyResponse();
        Arr::forget($service, 'rules');
        ksort($service);
        return [
            $service,
        ];
    }
}
