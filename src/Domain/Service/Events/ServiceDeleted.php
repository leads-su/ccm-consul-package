<?php

namespace ConsulConfigManager\Consul\Domain\Service\Events;

use ConsulConfigManager\Consul\Domain\Abstracts\AbstractEvent;

/**
 * Class ServiceDeleted
 * @package ConsulConfigManager\Consul\Domain\Service\Events
 */
class ServiceDeleted extends AbstractEvent
{
    /**
     * ServiceDeleted constructor.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
}
