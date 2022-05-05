<?php

namespace ConsulConfigManager\Consul\Domain\Service\UseCases\Service;

use Throwable;
use ConsulConfigManager\Domain\Interfaces\ViewModel;

/**
 * Interface ServiceOutputPort
 * @package ConsulConfigManager\Consul\Domain\Service\UseCases\Service
 */
interface ServiceOutputPort
{
    /**
     * Output port for "missing identifier"
     * @param ServiceResponseModel $serviceResponseModel
     * @return ViewModel
     */
    public function missingIdentifier(ServiceResponseModel $serviceResponseModel): ViewModel;

    /**
     * Output port for "service information"
     * @param ServiceResponseModel $serviceResponseModel
     * @return ViewModel
     */
    public function serviceInformation(ServiceResponseModel $serviceResponseModel): ViewModel;

    /**
     * Output port for "service not found"
     * @param ServiceResponseModel $serviceResponseModel
     * @return ViewModel
     */
    public function serviceNotFound(ServiceResponseModel $serviceResponseModel): ViewModel;

    /**
     * Output port for "internal server error"
     * @param ServiceResponseModel $serviceResponseModel
     * @param Throwable $exception
     * @throws Throwable
     * @return ViewModel
     */
    public function internalServerError(ServiceResponseModel $serviceResponseModel, Throwable $exception): ViewModel;
}
