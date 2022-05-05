<?php

namespace ConsulConfigManager\Consul\Services;

use Consul\Services\AccessControlList\AccessControlList;
use ConsulConfigManager\Consul\Interfaces\Services\AccessControlListServiceInterface;

/**
 * Class AccessControlListService
 *
 * @package ConsulConfigManager\Consul\Services
 */
class AccessControlListService extends AbstractService implements AccessControlListServiceInterface
{
    /**
     * SDK service reference
     * @var AccessControlList
     */
    private AccessControlList $service;

    /**
     * AccessControlListService Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->service = new AccessControlList($this->client());
    }

    /**
     * @inheritDoc
     */
    public function replicationStatus(string $datacenter): array
    {
        return (new ResponseTransformerService($this->service->replicationStatus($datacenter)))
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function translateRule(string $rule): string
    {
        return $this->service->translateRule($rule);
    }

    /**
     * @inheritDoc
     */
    public function createToken(array $options = []): array
    {
        return (new ResponseTransformerService($this->service->createToken($options)))
            ->mapContains($this->remapIdentifierKey())
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function readToken(string $accessorID): array
    {
        return (new ResponseTransformerService($this->service->readToken($accessorID)))
            ->mapContains($this->remapIdentifierKey())
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function updateToken(string $accessorID, array $options = []): array
    {
        return (new ResponseTransformerService($this->service->updateToken($accessorID, $options)))
            ->mapContains($this->remapIdentifierKey())
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function deleteToken(string $accessorID): bool
    {
        return $this->service->deleteToken($accessorID);
    }

    /**
     * @inheritDoc
     */
    public function myToken(): array
    {
        return (new ResponseTransformerService($this->service->myToken()))
            ->mapContains($this->remapIdentifierKey())
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function listTokens(array $options = []): array
    {
        return (new ResponseTransformerService($this->service->listTokens($options)))
            ->mapContains($this->remapIdentifierKey())
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function createRole(array $options = []): array
    {
        return (new ResponseTransformerService($this->service->createRole($options)))
            ->mapContains($this->remapIdentifierKey())
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function readRole(string $accessorID): array
    {
        return (new ResponseTransformerService($this->service->readRole($accessorID)))
            ->mapContains($this->remapIdentifierKey())
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function readRoleByName(string $roleName): array
    {
        return (new ResponseTransformerService($this->service->readRoleByName($roleName)))
            ->mapContains($this->remapIdentifierKey())
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function updateRole(string $accessorID, array $options = []): array
    {
        return (new ResponseTransformerService($this->service->updateRole($accessorID, $options)))
            ->mapContains($this->remapIdentifierKey())
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function deleteRole(string $accessorID): bool
    {
        return $this->service->deleteRole($accessorID);
    }

    /**
     * @inheritDoc
     */
    public function listRoles(array $options = []): array
    {
        return (new ResponseTransformerService($this->service->listRoles($options)))
            ->mapContains($this->remapIdentifierKey())
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function createPolicy(array $options = []): array
    {
        return (new ResponseTransformerService($this->service->createPolicy($options)))
            ->mapContains($this->remapIdentifierKey())
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function readPolicy(string $accessorID): array
    {
        return (new ResponseTransformerService($this->service->readPolicy($accessorID)))
            ->mapContains($this->remapIdentifierKey())
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function readPolicyByName(string $policyName): array
    {
        return (new ResponseTransformerService($this->service->readPolicyByName($policyName)))
            ->mapContains($this->remapIdentifierKey())
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function updatePolicy(string $accessorID, array $options = []): array
    {
        return (new ResponseTransformerService($this->service->updatePolicy($accessorID, $options)))
            ->mapContains($this->remapIdentifierKey())
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function deletePolicy(string $accessorID): bool
    {
        return $this->service->deletePolicy($accessorID);
    }

    /**
     * @inheritDoc
     */
    public function listPolicies(array $options = []): array
    {
        return (new ResponseTransformerService($this->service->listPolicies($options)))
            ->mapContains($this->remapIdentifierKey())
            ->getFormattedResponse();
    }

    /**
     * Remap identifier key
     * @return string[]
     */
    private function remapIdentifierKey(): array
    {
        return [
            'ID'    =>  'Id',
        ];
    }
}
