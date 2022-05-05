<?php

namespace ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\Get;

use Throwable;
use ConsulConfigManager\Domain\Interfaces\ViewModel;

/**
 * Interface ACLPolicyGetOutputPort
 * @package ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\Get
 */
interface ACLPolicyGetOutputPort
{
    /**
     * Output port for "get"
     * @param ACLPolicyGetResponseModel $responseModel
     * @return ViewModel
     */
    public function get(ACLPolicyGetResponseModel $responseModel): ViewModel;

    /**
     * Output port for "not found"
     * @param ACLPolicyGetResponseModel $responseModel
     * @return ViewModel
     */
    public function notFound(ACLPolicyGetResponseModel $responseModel): ViewModel;

    /**
     * Output port for "internal server error"
     * @param ACLPolicyGetResponseModel $responseModel
     * @param Throwable $exception
     * @return ViewModel
     */
    public function internalServerError(ACLPolicyGetResponseModel $responseModel, Throwable $exception): ViewModel;
}
