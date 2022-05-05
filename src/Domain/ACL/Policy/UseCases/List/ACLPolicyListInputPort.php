<?php

namespace ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\List;

use ConsulConfigManager\Domain\Interfaces\ViewModel;

/**
 * Interface ACLPolicyListInputPort
 * @package ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\List
 */
interface ACLPolicyListInputPort
{
    /**
     * Get list of all ACL policies
     * @param ACLPolicyListRequestModel $requestModel
     * @return ViewModel
     */
    public function list(ACLPolicyListRequestModel $requestModel): ViewModel;
}
