<?php

namespace ConsulConfigManager\Consul\Domain\Service\Presenters;

use Throwable;
use Illuminate\Http\Response;
use ConsulConfigManager\Domain\Interfaces\ViewModel;
use ConsulConfigManager\Domain\ViewModels\HttpResponseViewModel;
use ConsulConfigManager\Consul\Domain\Service\UseCases\Services\ServicesOutputPort;
use ConsulConfigManager\Consul\Domain\Service\UseCases\Services\ServicesResponseModel;

/**
 * Class ServiceHttpPresenter
 * @package ConsulConfigManager\Consul\Domain\Service\Presenters
 */
class ServicesHttpPresenter implements ServicesOutputPort
{
    /**
     * @inheritDoc
     */
    public function services(ServicesResponseModel $servicesResponseModel): ViewModel
    {
        return new HttpResponseViewModel(response_success(
            $servicesResponseModel->getCollection()->toArray(),
            'Successfully fetched list of available services',
            Response::HTTP_OK
        ));
    }

    /**
     * @inheritDoc
     */
    public function internalServerError(ServicesResponseModel $serviceResponseModel, Throwable $exception): ViewModel
    {
        if (config('app.debug')) {
            throw $exception;
        }
        return new HttpResponseViewModel(response_error(
            $exception,
            'Unable to list of services'
        ));
    }
}
