<?php

namespace ConsulConfigManager\Consul\Domain\KeyValue\Projectors;

use Illuminate\Support\Arr;
use ConsulConfigManager\Consul\Models\KeyValue;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;
use ConsulConfigManager\Consul\Domain\KeyValue\Events\KeyValueCreated;
use ConsulConfigManager\Consul\Domain\KeyValue\Events\KeyValueDeleted;
use ConsulConfigManager\Consul\Domain\KeyValue\Events\KeyValueUpdated;

/**
 * Class KeyValueProjector
 * @package ConsulConfigManager\Consul\Domain\KeyValue\Projectors
 */
class KeyValueProjector extends Projector
{
    /**
     * Handle `create` event
     * @param KeyValueCreated $event
     * @return void
     */
    public function onKeyValueCreated(KeyValueCreated $event): void
    {
        $value = $event->getValue();

        KeyValue::create([
            'uuid'      =>  $event->aggregateRootUuid(),
            'path'      =>  trim($event->getPath()),
            'value'     =>  $value,
            'reference' =>  Arr::get($value, 'type') === 'reference',
        ]);
    }

    /**
     * Handle `update` event
     * @param KeyValueUpdated $event
     * @return void
     */
    public function onKeyValueUpdated(KeyValueUpdated $event): void
    {
        $value = $event->getValue();

        $model = KeyValue::uuid($event->aggregateRootUuid());
        $model->value = $value;
        $model->reference = Arr::get($value, 'type') === 'reference';
        $model->save();
    }

    /**
     * Handle `delete` event
     * @param KeyValueDeleted $event
     * @return void
     */
    public function onKeyValueDeleted(KeyValueDeleted $event): void
    {
        KeyValue::uuid($event->aggregateRootUuid())->delete();
    }
}
