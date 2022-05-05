<?php

namespace ConsulConfigManager\Consul\Domain\KeyValue\Repositories;

use Throwable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use ConsulConfigManager\Consul\Models\KeyValue;
use ConsulConfigManager\Consul\Domain\KeyValue\KeyValueAggregateRoot;
use ConsulConfigManager\Consul\Domain\KeyValue\Interfaces\KeyValueEntity;

/**
 * Class KeyValueRepository
 *
 * @package ConsulConfigManager\Consul\Domain\KeyValue\Repositories
 */
class KeyValueRepository implements KeyValueRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function all(array $columns = ['*']): Collection
    {
        return KeyValue::all($columns);
    }

    /**
     * @inheritDoc
     */
    public function allKeys(): array
    {
        return array_map(static function (array $entity): string {
            return Arr::get($entity, 'path');
        }, $this->all()->toArray());
    }

    /**
     * @inheritDoc
     */
    public function allNamespaced(array $columns = ['*']): array
    {
        $keys = $this->allKeys();

        $namespaced = [];

        foreach ($keys as $key) {
            $namespace = Arr::first(explode('/', $key));
            $namespaced[$namespace][] = $key;
        }

        return $namespaced;
    }

    /**
     * @inheritDoc
     */
    public function find(string $path, array $columns = ['*']): KeyValueEntity|Model|null
    {
        return KeyValue::where('path', '=', $path)->first($columns);
    }

    /**
     * @inheritDoc
     */
    public function findOrFail(string $path, array $columns = ['*']): KeyValueEntity
    {
        return KeyValue::where('path', '=', $path)->firstOrFail($columns);
    }

    /**
     * @inheritDoc
     */
    public function changelog(string $path): \Illuminate\Support\Collection
    {
        return $this->findOrFail($path, ['uuid'])->history();
    }

    /**
     * @inheritDoc
     */
    public function create(string $path, array $value): KeyValueEntity
    {
        $uuid = Str::uuid()->toString();
        $path = trim($path);

        KeyValueAggregateRoot::retrieve($uuid)
            ->createEntity($path, $value)
            ->persist();

        return $this->find($path);
    }

    /**
     * @inheritDoc
     */
    public function update(string $path, array $value): KeyValueEntity
    {
        $path = trim($path);
        $model = $this->findOrFail($path, ['uuid']);

        KeyValueAggregateRoot::retrieve($model->getUuid())
            ->updateEntity($value)
            ->persist();

        return $this->find($path);
    }

    /**
     * @inheritDoc
     */
    public function delete(string $path, bool $forceDelete = false): bool
    {
        try {
            $path = trim($path);
            $model = $this->findOrFail($path, ['uuid']);

            KeyValueAggregateRoot::retrieve($model->getUuid())
                ->deleteEntity()
                ->persist();

            return true;
        } catch (Throwable) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function forceDelete(string $path): bool
    {
        return $this->delete($path, true);
    }

    /**
     * @inheritDoc
     */
    public function references(): array
    {
        $models = (new KeyValue())->references()->get();

        $references = [];
        $resolved = [];

        foreach ($models as $index => $model) {
            $value = Arr::get($model->value, 'value');

            Arr::set($references, $index, [
                'text'      =>  $value,
                'value'     =>  $value,
            ]);
            if (!Arr::exists($resolved, $value)) {
                Arr::set($resolved, $value, null);
            }
        }

        $dataForResolved = (new KeyValue())->whereIn('path', array_keys($resolved))->get();

        // Required to set initial data
        foreach ($dataForResolved as $model) {
            if (!$model->reference) {
                Arr::set($resolved, $model->path, Arr::get($model->value, 'value'));
            }
        }

        // Required to resolve remaining data
        foreach ($dataForResolved as $model) {
            if ($model->reference) {
                Arr::set($resolved, $model->path, Arr::get($model->resolveReferenceValue(), 'value'));
            }
        }

        foreach ($references as $index => $reference) {
            $key = Arr::get($reference, 'value');
            $value = Arr::get($resolved, $key);
            Arr::set($references, $index . '.description', $value);
        }

        return $references;
    }
}
