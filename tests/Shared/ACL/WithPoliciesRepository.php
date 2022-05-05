<?php

namespace ConsulConfigManager\Consul\Test\Shared\ACL;

use Mockery;
use Mockery\MockInterface;
use Illuminate\Support\Str;
use ConsulConfigManager\Consul\Models\Policy;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Interfaces\ACLPolicyEntity;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Repositories\ACLPolicyRepositoryInterface;

/**
 * Trait WithPoliciesRepository
 * @package ConsulConfigManager\Consul\Test\Shared\ACL
 */
trait WithPoliciesRepository
{
    /**
     * Array of Policy entries
     * @var array|array[]
     */
    private array $policyEntries = [
        [
            'id'            =>  '1e8f8bb7-0111-450a-3f05-56d4e3911bb9',
            'uuid'          =>  '0ead0ce3-1651-446e-9935-e558ad766eac',
            'name'          =>  'example_policy',
            'description'   =>  'This is an example policy.',
            'rules'         =>  '',
            'created_at'    =>  1630914000,
            'updated_at'    =>  1630914000,
            'deleted_at'    =>  null,
        ],
    ];

    /**
     * Repository mock instance
     * @var MockInterface
     */
    private MockInterface $policyRepositoryMock;

    /**
     * Create bootstrapped instance of ACLPolicyRepositoryInterface
     * @param bool $withData
     * @param bool $mock
     * @return ACLPolicyRepositoryInterface
     */
    protected function policyRepository(bool $withData = false, bool $mock = false): ACLPolicyRepositoryInterface
    {
        if ($withData) {
            foreach ($this->policyEntries as $entry) {
                Policy::create($entry);
            }
        }

        if (!$mock) {
            return $this->app->make(ACLPolicyRepositoryInterface::class);
        }
        $this->policyRepositoryMock = Mockery::mock(ACLPolicyRepositoryInterface::class);

        $this
            ->policyBootstrapCreateMethod()
            ->policyBootstrapUpdateMethod()
            ->policyBootstrapDeleteMethod();

        return $this->policyRepositoryMock;
    }

    /**
     * Ensure that repository is able to respond to `create` method
     * @return static|self|$this
     */
    private function policyBootstrapCreateMethod(): self
    {
        $this->policyRepositoryMock
            ->shouldReceive('create')
            ->withArgs(function (string $id, string $name, string $description, string $rules): bool {
                return true;
            })->andReturnUsing(function (string $id, string $name, string $description, string $rules): ACLPolicyEntity {
                return $this->createPolicyEntityFromArray([
                    'id'            =>  $id,
                    'uuid'          =>  Str::uuid()->toString(),
                    'name'          =>  $name,
                    'description'   =>  $description,
                    'rules'         =>  $rules,
                    'created_at'    =>  time(),
                    'updated_at'    =>  time(),
                    'deleted_at'    =>  null,
                ]);
            });
        return $this;
    }

    /**
     * Ensure that repository is able to respond to `update` method
     * @return static|self|$this
     */
    private function policyBootstrapUpdateMethod(): self
    {
        $this->policyRepositoryMock
            ->shouldReceive('update')
            ->withArgs(function (string $id, string $name, string $description, string $rules): bool {
                return true;
            })->andReturnUsing(function (string $id, string $name, string $description, string $rules): ACLPolicyEntity {
                return $this->createPolicyEntityFromArray([
                    'id'            =>  $id,
                    'name'          =>  $name,
                    'description'   =>  $description,
                    'rules'         =>  $rules,
                ]);
            });
        return $this;
    }

    /**
     * Ensure that repository is able to respond to `delete` method
     * @return static|self|$this
     */
    private function policyBootstrapDeleteMethod(): self
    {
        $this->policyRepositoryMock
            ->shouldReceive('delete')
            ->with(function (string $id, bool $forceDelete = false): bool {
                return true;
            })->andReturnUsing(function (string $id, bool $forceDelete = false): bool {
                return true;
            });
        return $this;
    }

    /**
     * Create new policy entity from provided array
     * @param array $data
     * @return ACLPolicyEntity
     */
    private function createPolicyEntityFromArray(array $data): ACLPolicyEntity
    {
        return Policy::factory()->make($data);
    }
}
