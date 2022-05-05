<?php

namespace ConsulConfigManager\Consul\Domain\KeyValue\Events;

use ConsulConfigManager\Users\Interfaces\UserInterface;
use ConsulConfigManager\Consul\Domain\Abstracts\AbstractEvent;

/**
 * Class KeyValueUpdated
 * @package ConsulConfigManager\Consul\Domain\KeyValue\Events
 */
class KeyValueUpdated extends AbstractEvent
{
    /**
     * Key value
     * @var array
     */
    private array $value;

    /**
     * KeyValueUpdated constructor.
     * @param array $value
     * @param UserInterface|null $user
     */
    public function __construct(array $value, ?UserInterface $user = null)
    {
        $this->value = $value;
        $this->user = $user;
        parent::__construct();
    }

    /**
     * Get key value
     * @return array
     */
    public function getValue(): array
    {
        return $this->value;
    }
}
