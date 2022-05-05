<?php

namespace ConsulConfigManager\Consul\Domain\Service\UseCases\Services;

use Throwable;
use ConsulConfigManager\Domain\Interfaces\ViewModel;

/**
 * Interface ServicesOutputPort
 * @package ConsulConfigManager\Consul\Domain\Service\UseCases\Services
 */
interface ServicesOutputPort
{
    /**
     * Get list of all available services
     * @param ServicesResponseModel $servicesResponseModel
     * @return ViewModel
     */
    public function services(ServicesResponseModel $servicesResponseModel): ViewModel;

    /**
     * Handle internal server error
     * @param ServicesResponseModel $serviceResponseModel
     * @param Throwable $exception
     * @throws Throwable
     * @return ViewModel
     */
    public function internalServerError(ServicesResponseModel $serviceResponseModel, Throwable $exception): ViewModel;
}
