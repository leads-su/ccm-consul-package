<?php

namespace ConsulConfigManager\Consul\Domain\Service\UseCases\Services;

use ConsulConfigManager\Domain\Interfaces\ViewModel;
use ConsulConfigManager\Consul\Domain\Service\UseCases\Service\ServiceRequestModel;

/**
 * Interface ServicesInputPort
 * @package ConsulConfigManager\Consul\Domain\Service\UseCases\Services
 */
interface ServicesInputPort
{
    /**
     * Retrieve list of available services
     * @param ServiceRequestModel $serviceRequestModel
     * @return ViewModel
     */
    public function services(ServiceRequestModel $serviceRequestModel): ViewModel;
}
