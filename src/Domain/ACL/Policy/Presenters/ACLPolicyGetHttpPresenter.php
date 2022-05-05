<?php

namespace ConsulConfigManager\Consul\Domain\ACL\Policy\Presenters;

use Throwable;
use Illuminate\Http\Response;
use ConsulConfigManager\Domain\Interfaces\ViewModel;
use ConsulConfigManager\Domain\ViewModels\HttpResponseViewModel;
use ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\Get\ACLPolicyGetOutputPort;
use ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\Get\ACLPolicyGetResponseModel;

/**
 * Class ACLPolicyCreateHttpPresenter
 * @package ConsulConfigManager\Consul\Domain\ACL\Policy\Presenters
 */
class ACLPolicyGetHttpPresenter implements ACLPolicyGetOutputPort
{
    /**
     * @inheritDoc
     */
    public function get(ACLPolicyGetResponseModel $responseModel): ViewModel
    {
        return new HttpResponseViewModel(response_success(
            $responseModel->getEntity()->toArray(),
            'Successfully fetched policy information',
            Response::HTTP_OK,
        ));
    }

    /**
     * @inheritDoc
     */
    public function notFound(ACLPolicyGetResponseModel $responseModel): ViewModel
    {
        return new HttpResponseViewModel(response_error(
            [],
            'Unable to find policy',
            Response::HTTP_NOT_FOUND,
        ));
    }

    /**
     * @inheritDoc
     */
    public function internalServerError(ACLPolicyGetResponseModel $responseModel, Throwable $exception): ViewModel
    {
        if (config('app.debug')) {
            throw $exception;
        }

        return new HttpResponseViewModel(response_error(
            $exception,
            'Unable to retrieve policy information'
        ));
    }
}
