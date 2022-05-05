<?php

namespace ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\Get;

use Illuminate\Http\Request;

/**
 * Class ACLPolicyGetRequestModel
 * @package ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\Get
 */
class ACLPolicyGetRequestModel
{
    /**
     * Request instance
     * @var Request
     */
    private Request $request;

    /**
     * Policy ID
     * @var string
     */
    private string $policyID;

    /**
     * ACLPolicyGetRequestModel constructor.
     * @param Request $request
     * @param string $policyID
     */
    public function __construct(Request $request, string $policyID)
    {
        $this->request = $request;
        $this->policyID = $policyID;
    }

    /**
     * Get request instance
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Get policy id
     * @return string
     */
    public function getPolicyID(): string
    {
        return $this->policyID;
    }
}
