<?php

namespace ConsulConfigManager\Consul\Domain\Service\Events;

use ConsulConfigManager\Consul\Domain\Abstracts\AbstractEvent;

/**
 * Class ServiceCreated
 * @package ConsulConfigManager\Consul\Domain\Service\Events
 */
class ServiceCreated extends AbstractEvent
{
    /**
     * Service configuration array
     * @var array
     */
    private array $configuration;

    /**
     * ServiceCreated constructor.
     * @param array $configuration
     * @return void
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
        parent::__construct();
    }

    /**
     * Get service configuration
     * @return array
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }
}
