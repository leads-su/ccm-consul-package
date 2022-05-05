<?php

namespace ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\List;

/**
 * Class ACLPolicyListResponseModel
 * @package ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\List
 */
class ACLPolicyListResponseModel
{
    /**
     * List of policies
     * @var array
     */
    private array $policies;

    /**
     * ACLPolicyListResponseModel constructor.
     * @param array $policies
     * @return void
     */
    public function __construct(array $policies = [])
    {
        $this->policies = $policies;
    }

    /**
     * Get list of policies
     * @return array
     */
    public function getPolicies(): array
    {
        return $this->policies;
    }
}
