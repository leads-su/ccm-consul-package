<?php

namespace ConsulConfigManager\Consul\Traits;

use Illuminate\Support\Arr;
use ConsulConfigManager\Consul\Domain\Service\Repositories\ServiceRepository;
use ConsulConfigManager\Consul\Domain\KeyValue\Repositories\KeyValueRepository;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Repositories\ACLPolicyRepository;
use ConsulConfigManager\Consul\Domain\Service\Repositories\ServiceRepositoryInterface;
use ConsulConfigManager\Consul\Domain\KeyValue\Repositories\KeyValueRepositoryInterface;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Repositories\ACLPolicyRepositoryInterface;

/**
 * Trait WithMappings
 *
 * @package ConsulConfigManager\Consul\Traits
 */
trait WithMappings
{
    /**
     * List of interfaces offered by the SDK
     * @var array
     */
    private array $sdkInterfaces = [

    ];

    /**
     * Access Control List service mappings array
     * @var array
     */
    private array $aclServiceMappings = [
        'repositories'      =>  [
            ACLPolicyRepositoryInterface::class =>  ACLPolicyRepository::class,
        ],
    ];

    /**
     * Agent service mappings array
     * @var array
     */
    private array $agentServiceMappings = [
        'repositories'      =>  [

        ],
    ];

    /**
     * Catalog service mappings array
     * @var array
     */
    private array $catalogServiceMappings = [
        'repositories'      =>  [

        ],
    ];

    /**
     * Key Value service mappings array
     * @var array
     */
    private array $keyValueServiceMappings = [
        'repositories'      =>  [
            KeyValueRepositoryInterface::class      =>  KeyValueRepository::class,
            ServiceRepositoryInterface::class       =>  ServiceRepository::class,
        ],
    ];

    /**
     * Get list of repositories mappings
     * @return array
     */
    protected function repositoriesMappings(): array
    {
        $mappings = [];
        $sources = [
            'aclServiceMappings',
            'agentServiceMappings',
            'catalogServiceMappings',
            'keyValueServiceMappings',
        ];

        foreach ($sources as $source) {
            $sourceData = $this->$source;
            if (Arr::exists($sourceData, 'repositories')) {
                foreach (Arr::get($sourceData, 'repositories') as $interface => $implementation) {
                    $mappings[$interface] = $implementation;
                }
            }
        }

        return $mappings;
    }
}
