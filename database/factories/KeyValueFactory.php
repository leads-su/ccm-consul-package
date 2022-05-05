<?php

namespace ConsulConfigManager\Consul\Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use ConsulConfigManager\Consul\Models\KeyValue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class KeyValueFactory
 *
 * @package ConsulConfigManager\Consul\Database\Factories
 */
class KeyValueFactory extends Factory
{
    /**
     * The name of factory's corresponding model.
     * @var string
     */
    protected $model = KeyValue::class;

    public function definition(): array
    {
        return [
            'id'            =>  $this->faker->unique()->numberBetween(1, 10),
            'uuid'          =>  $this->faker->uuid(),
            'path'          =>  sprintf('consul/%s', Str::snake(rtrim($this->faker->sentence(2), '.'))),
            'value'         =>  [
                'type'      =>  'string',
                'value'     =>  $this->faker->sentence(3),
            ],
            'reference'     =>  false,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
            'deleted_at'    =>  null,
        ];
    }
}
