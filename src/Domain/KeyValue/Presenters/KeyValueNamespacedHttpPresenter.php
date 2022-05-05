<?php

namespace ConsulConfigManager\Consul\Domain\KeyValue\Presenters;

use Throwable;
use Illuminate\Http\Response;
use ConsulConfigManager\Domain\Interfaces\ViewModel;
use ConsulConfigManager\Domain\ViewModels\HttpResponseViewModel;
use ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Namespaced\KeyValueNamespacedOutputPort;
use ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Namespaced\KeyValueNamespacedResponseModel;

/**
 * Class KeyValueNamespacedHttpPresenter
 * @package ConsulConfigManager\Consul\Domain\KeyValue\Presenters
 */
class KeyValueNamespacedHttpPresenter implements KeyValueNamespacedOutputPort
{
    /**
     * @inheritDoc
     */
    public function namespaced(KeyValueNamespacedResponseModel $responseModel): ViewModel
    {
        return new HttpResponseViewModel(response_success(
            $responseModel->getNamespaced(),
            'Successfully fetched namespaced keys',
            Response::HTTP_OK,
        ));
    }

    /**
     * @inheritDoc
     */
    public function internalServerError(KeyValueNamespacedResponseModel $responseModel, Throwable $exception): ViewModel
    {
        if (config('app.debug')) {
            throw $exception;
        }
        return new HttpResponseViewModel(response_error(
            $exception,
            'Unable to retrieve namespaced keys'
        ));
    }
}
