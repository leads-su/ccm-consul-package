<?php

namespace ConsulConfigManager\Consul\Database\Factories;

use Illuminate\Support\Carbon;
use ConsulConfigManager\Consul\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class ServiceFactory
 * @package ConsulConfigManager\Consul\Database\Factories
 */
class ServiceFactory extends Factory
{
    /**
     * The name of factory's corresponding model.
     * @var string
     */
    protected $model = Service::class;

    public function definition(): array
    {
        $ipv4 = $this->faker->ipv4();
        return [
            'id'                        =>  $this->faker->unique()->numberBetween(1, 10),
            'uuid'                      =>  $this->faker->uuid(),
            'identifier'                =>  'ccm-example-' . $ipv4,
            'service'                   =>  'ccm',
            'address'                   =>  $ipv4,
            'port'                      =>  32175,
            'datacenter'                =>  'dc0',
            'tags'                      =>  [],
            'meta'                      =>  [
                'operating_system'      =>  'linux',
                'log_level'             =>  'DEBUG',
                'go_version'            =>  '1.17.2',
                'environment'           =>  'development',
                'architecture'          =>  'amd64',
                'application_version'   =>  $this->faker->semver(),
            ],
            'online'                    =>  true,
            'environment'               =>  'development',
            'created_at'                =>  Carbon::now(),
            'updated_at'                =>  Carbon::now(),
            'deleted_at'                =>  null,
        ];
    }
}
