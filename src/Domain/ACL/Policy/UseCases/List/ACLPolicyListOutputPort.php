<?php

namespace ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\List;

use Throwable;
use ConsulConfigManager\Domain\Interfaces\ViewModel;

/**
 * Interface ACLPolicyListOutputPort
 * @package ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\List
 */
interface ACLPolicyListOutputPort
{
    /**
     * Output port for "list"
     * @param ACLPolicyListResponseModel $responseModel
     * @return ViewModel
     */
    public function list(ACLPolicyListResponseModel $responseModel): ViewModel;

    /**
     * Output port for "internal server error"
     * @param ACLPolicyListResponseModel $responseModel
     * @param Throwable $exception
     * @return ViewModel
     */
    public function internalServerError(ACLPolicyListResponseModel $responseModel, Throwable $exception): ViewModel;
}
