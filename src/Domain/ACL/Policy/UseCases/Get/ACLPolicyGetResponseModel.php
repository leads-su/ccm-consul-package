<?php

namespace ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\Get;

use ConsulConfigManager\Consul\Domain\ACL\Policy\Interfaces\ACLPolicyEntity;

/**
 * Class ACLPolicyGetResponseModel
 * @package ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\Get
 */
class ACLPolicyGetResponseModel
{
    /**
     * Entity instance
     * @var ACLPolicyEntity|null
     */
    private ?ACLPolicyEntity $entity;

    /**
     * ACLPolicyGetResponseModel constructor.
     * @param ACLPolicyEntity|null $entity
     * @return void
     */
    public function __construct(?ACLPolicyEntity $entity = null)
    {
        $this->entity = $entity;
    }

    /**
     * Get entity
     * @return ACLPolicyEntity|null
     */
    public function getEntity(): ?ACLPolicyEntity
    {
        return $this->entity;
    }
}
