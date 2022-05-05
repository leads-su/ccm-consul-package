<?php

namespace ConsulConfigManager\Consul\Database\Factories;

use Illuminate\Support\Carbon;
use ConsulConfigManager\Consul\Models\Policy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class ACLPolicyFactory
 * @package ConsulConfigManager\Consul\Database\Factories
 */
class ACLPolicyFactory extends Factory
{
    /**
     * The name of factory's corresponding model.
     * @var string
     */
    protected $model = Policy::class;

    public function definition(): array
    {
        return [
            'id'            =>  $this->faker->unique()->numberBetween(1, 10),
            'uuid'          =>  $this->faker->uuid(),
            'name'          =>  strtolower($this->faker->firstName()) . '_' . strtolower($this->faker->lastName),
            'description'   =>  $this->faker->text(),
            'rules'         =>  '',
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
            'deleted_at'    =>  null,
        ];
    }
}
