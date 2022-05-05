<?php

namespace ConsulConfigManager\Consul\Domain\ACL\Policy;

use Spatie\EventSourcing\AggregateRoots\AggregateRoot;
use ConsulConfigManager\Users\Interfaces\UserInterface;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Events\ACLPolicyCreated;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Events\ACLPolicyDeleted;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Events\ACLPolicyUpdated;

/**
 * Class ACLPolicyAggregateRoot
 * @package ConsulConfigManager\Consul\Domain\ACL\Policy
 */
class ACLPolicyAggregateRoot extends AggregateRoot
{
    /**
     * Handle `create` event
     * @param string $id
     * @param string $name
     * @param string $description
     * @param string $rules
     * @param UserInterface|null $user
     * @return $this
     */
    public function createEntity(string $id, string $name, string $description, string $rules, ?UserInterface $user = null): ACLPolicyAggregateRoot
    {
        $this->recordThat(new ACLPolicyCreated(
            $id,
            $name,
            $description,
            $rules,
            $user
        ));
        return $this;
    }

    /**
     * Handle `update` event
     * @param string $name
     * @param string $description
     * @param string $rules
     * @param UserInterface|null $user
     * @return $this
     */
    public function updateEntity(string $name, string $description, string $rules, ?UserInterface $user = null): ACLPolicyAggregateRoot
    {
        $this->recordThat(new ACLPolicyUpdated(
            $name,
            $description,
            $rules,
            $user
        ));
        return $this;
    }

    /**
     * Handle `delete` event
     * @param UserInterface|null $user
     * @return $this
     */
    public function deleteEntity(?UserInterface $user = null): ACLPolicyAggregateRoot
    {
        $this->recordThat(new ACLPolicyDeleted($user));
        return $this;
    }
}
