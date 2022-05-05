<?php

namespace ConsulConfigManager\Consul\Domain\KeyValue\Events;

use ConsulConfigManager\Users\Interfaces\UserInterface;
use ConsulConfigManager\Consul\Domain\Abstracts\AbstractEvent;

/**
 * Class KeyValueCreated
 * @package ConsulConfigManager\Consul\Domain\KeyValue\Events
 */
class KeyValueCreated extends AbstractEvent
{
    /**
     * Key path
     * @var string
     */
    private string $path;

    /**
     * Key value
     * @var array
     */
    private array $value;

    /**
     * KeyValueCreated constructor.
     * @param string $path
     * @param array $value
     * @param UserInterface|null $user
     */
    public function __construct(string $path, array $value, ?UserInterface $user = null)
    {
        $this->path = $path;
        $this->value = $value;
        $this->user = $user;
        parent::__construct();
    }

    /**
     * Get key path
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
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
