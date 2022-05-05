<?php

namespace ConsulConfigManager\Consul\Domain\ACL\Policy\Events;

use ConsulConfigManager\Users\Interfaces\UserInterface;
use ConsulConfigManager\Consul\Domain\Abstracts\AbstractEvent;

/**
 * Class ACLPolicyDeleted
 * @package ConsulConfigManager\Consul\Domain\ACL\Policy\Events
 */
class ACLPolicyDeleted extends AbstractEvent
{
    /**
     * ACLPolicyDeleted constructor.
     * @param UserInterface|null $user
     * @return void
     */
    public function __construct(?UserInterface $user = null)
    {
        $this->user = $user;
        parent::__construct();
    }
}
