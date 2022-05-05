<?php

namespace ConsulConfigManager\Consul\Domain\Service\Projectors;

use Illuminate\Support\Arr;
use ConsulConfigManager\Consul\Models\Service;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;
use ConsulConfigManager\Consul\Domain\Service\Events\ServiceCreated;
use ConsulConfigManager\Consul\Domain\Service\Events\ServiceDeleted;
use ConsulConfigManager\Consul\Domain\Service\Events\ServiceUpdated;

/**
 * Class ServiceProjector
 * @package ConsulConfigManager\Consul\Domain\Service\Projectors
 */
class ServiceProjector extends Projector
{
    /**
     * Handle `create` event
     * @param ServiceCreated $event
     * @return void
     */
    public function onServiceCreated(ServiceCreated $event): void
    {
        $configuration = $this->processServiceConfiguration($event->aggregateRootUuid(), $event->getConfiguration());
        Service::create($configuration);
    }

    /**
     * Handle `update` event
     * @param ServiceUpdated $event
     * @return void
     */
    public function onServiceUpdated(ServiceUpdated $event): void
    {
        $uuid = $event->aggregateRootUuid();
        $configuration = $this->processServiceConfiguration($uuid, $event->getConfiguration());
        $model = Service::uuid($uuid);
        $model->setIdentifier(Arr::get($configuration, 'identifier'));
        $model->setService(Arr::get($configuration, 'service'));
        $model->setAddress(Arr::get($configuration, 'address'));
        $model->setPort(Arr::get($configuration, 'port'));
        $model->setDatacenter(Arr::get($configuration, 'datacenter'));
        $model->setTags(Arr::get($configuration, 'tags'));
        $model->setMeta(Arr::get($configuration, 'meta'));
        $model->setOnline(Arr::get($configuration, 'online'));
        $model->setEnvironment(Arr::get($configuration, 'environment', 'development'));
        $model->save();
    }

    /**
     * Handle `delete` event
     * @param ServiceDeleted $event
     * @return void
     */
    public function onServiceDeleted(ServiceDeleted $event): void
    {
        Service::uuid($event->aggregateRootUuid())->delete();
    }

    /**
     * Process service configuration
     * @param string $uuid
     * @param array $configuration
     * @return array
     */
    private function processServiceConfiguration(string $uuid, array $configuration): array
    {
        $finalArray = Arr::except($configuration, [
            'id',
            'socket_path',
            'tagged_addresses',
            'weights',
            'enable_tag_override',
        ]);
        Arr::set($finalArray, 'identifier', Arr::get($configuration, 'id'));
        Arr::set($finalArray, 'uuid', $uuid);
        Arr::set($finalArray, 'environment', Arr::get($configuration, 'meta.environment', 'development'));
        return $finalArray;
    }
}
