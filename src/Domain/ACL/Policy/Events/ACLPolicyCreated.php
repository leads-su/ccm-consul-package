<?php

namespace ConsulConfigManager\Consul\Domain\ACL\Policy\Events;

use ConsulConfigManager\Users\Interfaces\UserInterface;
use ConsulConfigManager\Consul\Domain\Abstracts\AbstractEvent;

/**
 * Class ACLPolicyCreate
 * @package ConsulConfigManager\Consul\Domain\ACL\Policy\Events
 */
class ACLPolicyCreated extends AbstractEvent
{
    /**
     * Policy id
     * @var string
     */
    private string $id;

    /**
     * Policy name
     * @var string
     */
    private string $name;

    /**
     * Policy description
     * @var string
     */
    private string $description;

    /**
     * Policy rules
     * @var string
     */
    private string $rules;

    /**
     * ACLPolicyCreated constructor.
     * @param string $id
     * @param string $name
     * @param string $description
     * @param string $rules
     * @param UserInterface|null $user
     */
    public function __construct(string $id, string $name, string $description, string $rules, ?UserInterface $user = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->rules = $rules;
        $this->user = $user;
        parent::__construct();
    }

    /**
     * Get policy id
     * @return string
     */
    public function getID(): string
    {
        return $this->id;
    }

    /**
     * Get policy name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get policy description
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Get policy rules
     * @return string
     */
    public function getRules(): string
    {
        return $this->rules;
    }
}
