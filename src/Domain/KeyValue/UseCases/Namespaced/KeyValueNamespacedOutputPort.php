<?php

namespace ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Namespaced;

use Throwable;
use ConsulConfigManager\Domain\Interfaces\ViewModel;

/**
 * Interface KeyValueNamespacedOutputPort
 * @package ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Namespaced
 */
interface KeyValueNamespacedOutputPort
{
    /**
     * Output port for "namespaced"
     * @param KeyValueNamespacedResponseModel $responseModel
     * @return ViewModel
     */
    public function namespaced(KeyValueNamespacedResponseModel $responseModel): ViewModel;

    /**
     * Output port for "internal server error"
     * @param KeyValueNamespacedResponseModel $responseModel
     * @param Throwable $exception
     * @return ViewModel
     */
    public function internalServerError(KeyValueNamespacedResponseModel $responseModel, Throwable $exception): ViewModel;
}
