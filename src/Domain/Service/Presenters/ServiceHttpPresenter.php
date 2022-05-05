<?php

namespace ConsulConfigManager\Consul\Domain\Service\Presenters;

use Throwable;
use Illuminate\Http\Response;
use ConsulConfigManager\Domain\Interfaces\ViewModel;
use ConsulConfigManager\Domain\ViewModels\HttpResponseViewModel;
use ConsulConfigManager\Consul\Domain\Service\UseCases\Service\ServiceOutputPort;
use ConsulConfigManager\Consul\Domain\Service\UseCases\Service\ServiceResponseModel;

/**
 * Class ServiceHttpPresenter
 * @package ConsulConfigManager\Consul\Domain\Service\Presenters
 */
class ServiceHttpPresenter implements ServiceOutputPort
{
    /**
     * @inheritDoc
     */
    public function missingIdentifier(ServiceResponseModel $serviceResponseModel): ViewModel
    {
        return new HttpResponseViewModel(response_error(
            [],
            'You have to specify service identifier',
            Response::HTTP_BAD_REQUEST,
        ));
    }

    /**
     * @inheritDoc
     */
    public function serviceInformation(ServiceResponseModel $serviceResponseModel): ViewModel
    {
        return new HttpResponseViewModel(response_success(
            $serviceResponseModel->getService(),
            'Successfully fetched service information',
            Response::HTTP_OK,
        ));
    }

    /**
     * @inheritDoc
     */
    public function serviceNotFound(ServiceResponseModel $serviceResponseModel): ViewModel
    {
        return new HttpResponseViewModel(response_error(
            [],
            'Unable to find requested service',
            Response::HTTP_NOT_FOUND,
        ));
    }

    /**
     * @inheritDoc
     */
    public function internalServerError(ServiceResponseModel $serviceResponseModel, Throwable $exception): ViewModel
    {
        if (config('app.debug')) {
            throw $exception;
        }
        return new HttpResponseViewModel(response_error(
            $exception,
            'Unable to retrieve service information'
        ));
    }
}
