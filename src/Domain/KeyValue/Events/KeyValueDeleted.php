<?php

namespace ConsulConfigManager\Consul\Domain\KeyValue\Events;

use ConsulConfigManager\Users\Interfaces\UserInterface;
use ConsulConfigManager\Consul\Domain\Abstracts\AbstractEvent;

/**
 * Class KeyValueDeleted
 * @package ConsulConfigManager\Consul\Domain\KeyValue\Events
 */
class KeyValueDeleted extends AbstractEvent
{
    /**
     * KeyValueDeleted constructor.
     * @param UserInterface|null $user
     */
    public function __construct(?UserInterface $user = null)
    {
        $this->user = $user;
        parent::__construct();
    }
}
