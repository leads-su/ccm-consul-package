<?php

namespace ConsulConfigManager\Consul\Domain\ACL\Policy\Presenters;

use Throwable;
use Illuminate\Http\Response;
use ConsulConfigManager\Domain\Interfaces\ViewModel;
use ConsulConfigManager\Domain\ViewModels\HttpResponseViewModel;
use ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\List\ACLPolicyListOutputPort;
use ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\List\ACLPolicyListResponseModel;

/**
 * Class ACLPolicyListHttpPresenter
 * @package ConsulConfigManager\Consul\Domain\ACL\Policy\Presenters
 */
class ACLPolicyListHttpPresenter implements ACLPolicyListOutputPort
{
    /**
     * @inheritDoc
     */
    public function list(ACLPolicyListResponseModel $responseModel): ViewModel
    {
        return new HttpResponseViewModel(response_success(
            $responseModel->getPolicies(),
            'Successfully fetched list of policies',
            Response::HTTP_OK
        ));
    }

    /**
     * @inheritDoc
     */
    public function internalServerError(ACLPolicyListResponseModel $responseModel, Throwable $exception): ViewModel
    {
        if (config('app.debug')) {
            throw $exception;
        }

        return new HttpResponseViewModel(response_error(
            $exception,
            'Unable to retrieve policies list'
        ));
    }
}
