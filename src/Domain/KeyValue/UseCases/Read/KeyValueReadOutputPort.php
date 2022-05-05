<?php

namespace ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Read;

use Throwable;
use ConsulConfigManager\Domain\Interfaces\ViewModel;

/**
 * Interface KeyValueReadOutputPort
 * @package ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Read
 */
interface KeyValueReadOutputPort
{
    /**
     * Output port for "missing key"
     * @param KeyValueReadResponseModel $responseModel
     * @return ViewModel
     */
    public function missingKey(KeyValueReadResponseModel $responseModel): ViewModel;

    /**
     * Output port for "read"
     * @param KeyValueReadResponseModel $responseModel
     * @return ViewModel
     */
    public function read(KeyValueReadResponseModel $responseModel): ViewModel;

    /**
     * Output port for "key not found"
     * @param KeyValueReadResponseModel $responseModel
     * @return ViewModel
     */
    public function keyNotFound(KeyValueReadResponseModel $responseModel): ViewModel;

    /**
     * Output port for "internal server error"
     * @param KeyValueReadResponseModel $responseModel
     * @param Throwable $exception
     * @return ViewModel
     */
    public function internalServerError(KeyValueReadResponseModel $responseModel, Throwable $exception): ViewModel;
}
