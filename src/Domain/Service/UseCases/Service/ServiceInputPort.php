<?php

namespace ConsulConfigManager\Consul\Domain\Service\UseCases\Service;

use ConsulConfigManager\Domain\Interfaces\ViewModel;

/**
 * Interface ServiceInputPort
 * @package ConsulConfigManager\Consul\Domain\Service\UseCases\Service
 */
interface ServiceInputPort
{
    /**
     * Get service information
     * @param ServiceRequestModel $serviceRequestModel
     * @return ViewModel
     */
    public function service(ServiceRequestModel $serviceRequestModel): ViewModel;
}
