<?php

namespace ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\List;

use Illuminate\Http\Request;

/**
 * Class ACLPolicyListRequestModel
 * @package ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\List
 */
class ACLPolicyListRequestModel
{
    /**
     * Request instance
     * @var Request
     */
    private Request $request;

    /**
     * ACLPolicyListRequestModel constructor.
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get request instance
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}
