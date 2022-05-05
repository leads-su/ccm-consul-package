<?php

namespace ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\Get;

use ConsulConfigManager\Domain\Interfaces\ViewModel;

/**
 * Interface ACLPolicyGetInputPort
 * @package ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\Get
 */
interface ACLPolicyGetInputPort
{
    /**
     * Retrieve policy
     * @param ACLPolicyGetRequestModel $requestModel
     * @return ViewModel
     */
    public function get(ACLPolicyGetRequestModel $requestModel): ViewModel;
}
