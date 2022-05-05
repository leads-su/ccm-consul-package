<?php

namespace ConsulConfigManager\Consul\Domain\KeyValue\Presenters;

use Throwable;
use Illuminate\Http\Response;
use ConsulConfigManager\Domain\Interfaces\ViewModel;
use ConsulConfigManager\Domain\ViewModels\HttpResponseViewModel;
use ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Read\KeyValueReadOutputPort;
use ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Read\KeyValueReadResponseModel;

/**
 * Class KeyValueReadHttpPresenter
 * @package ConsulConfigManager\Consul\Domain\KeyValue\Presenters
 */
class KeyValueReadHttpPresenter implements KeyValueReadOutputPort
{
    /**
     * @inheritDoc
     */
    public function missingKey(KeyValueReadResponseModel $responseModel): ViewModel
    {
        return new HttpResponseViewModel(response_error(
            [],
            'You have to specify key',
            Response::HTTP_BAD_REQUEST,
        ));
    }

    /**
     * @inheritDoc
     */
    public function read(KeyValueReadResponseModel $responseModel): ViewModel
    {
        return new HttpResponseViewModel(response_success(
            $responseModel->getKeyValue(),
            'Successfully fetched key value information',
            Response::HTTP_OK
        ));
    }

    /**
     * @inheritDoc
     */
    public function keyNotFound(KeyValueReadResponseModel $responseModel): ViewModel
    {
        return new HttpResponseViewModel(response_error(
            [],
            'Unable to find requested key value entity',
            Response::HTTP_NOT_FOUND,
        ));
    }

    /**
     * @inheritDoc
     */
    public function internalServerError(KeyValueReadResponseModel $responseModel, Throwable $exception): ViewModel
    {
        if (config('app.debug')) {
            throw $exception;
        }
        return new HttpResponseViewModel(response_error(
            $exception,
            'Unable to retrieve key value information'
        ));
    }
}
