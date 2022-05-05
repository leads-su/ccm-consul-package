<?php

namespace ConsulConfigManager\Consul\Domain\ACL\Policy\Projectors;

use ConsulConfigManager\Consul\Models\Policy;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Events\ACLPolicyCreated;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Events\ACLPolicyDeleted;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Events\ACLPolicyUpdated;

/**
 * Class ACLPolicyProjector
 * @package ConsulConfigManager\Consul\Domain\ACL\Policy\Projectors
 */
class ACLPolicyProjector extends Projector
{
    /**
     * Handle `create` event
     * @param ACLPolicyCreated $event
     * @return void
     */
    public function onPolicyCreated(ACLPolicyCreated $event): void
    {
        Policy::create([
            'id'            =>  $event->getID(),
            'uuid'          =>  $event->aggregateRootUuid(),
            'name'          =>  $event->getName(),
            'description'   =>  $event->getDescription(),
            'rules'         =>  $event->getRules(),
        ]);
    }

    /**
     * Handle `update` event
     * @param ACLPolicyUpdated $event
     * @return void
     */
    public function onPolicyUpdate(ACLPolicyUpdated $event): void
    {
        $uuid = $event->aggregateRootUuid();
        $model = Policy::uuid($uuid);
        $model->setName($event->getName());
        $model->setDescription($event->getDescription());
        $model->setRules($event->getRules());
        $model->save();
    }

    /**
     * Handle `create` event
     * @param ACLPolicyDeleted $event
     * @return void
     */
    public function onPolicyDeleted(ACLPolicyDeleted $event): void
    {
        Policy::uuid($event->aggregateRootUuid())->delete();
    }
}
