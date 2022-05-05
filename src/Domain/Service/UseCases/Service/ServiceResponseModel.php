<?php

namespace ConsulConfigManager\Consul\Domain\Service\UseCases\Service;

use ConsulConfigManager\Consul\Domain\Service\Interfaces\ServiceEntity;

/**
 * Class ServiceResponseModel
 * @package ConsulConfigManager\Consul\Domain\Service\UseCases\Service
 */
class ServiceResponseModel
{
    /**
     * Service model instance
     * @var ServiceEntity|null
     */
    private ?ServiceEntity $serviceEntity;

    /**
     * ServiceResponseModel constructor.
     * @param ServiceEntity|null $serviceEntity
     * @return void
     */
    public function __construct(?ServiceEntity $serviceEntity = null)
    {
        $this->serviceEntity = $serviceEntity;
    }

    /**
     * Get service
     * @return ServiceEntity|null
     */
    public function getService(): ?ServiceEntity
    {
        return $this->serviceEntity;
    }
}
