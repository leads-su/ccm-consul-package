<?php

namespace ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\Get;

use Throwable;
use ConsulConfigManager\Domain\Interfaces\ViewModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Repositories\ACLPolicyRepositoryInterface;

/**
 * Class ACLPolicyGetInteractor
 * @package ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\Get
 */
class ACLPolicyGetInteractor implements ACLPolicyGetInputPort
{
    /**
     * Output port instance
     * @var ACLPolicyGetOutputPort
     */
    private ACLPolicyGetOutputPort $output;

    /**
     * Repository instance
     * @var ACLPolicyRepositoryInterface
     */
    private ACLPolicyRepositoryInterface $repository;

    /**
     * ACLPolicyGetInteractor constructor.
     * @param ACLPolicyGetOutputPort $output
     * @param ACLPolicyRepositoryInterface $repository
     * @return void
     */
    public function __construct(ACLPolicyGetOutputPort $output, ACLPolicyRepositoryInterface $repository)
    {
        $this->output = $output;
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function get(ACLPolicyGetRequestModel $requestModel): ViewModel
    {
        $policyID = $requestModel->getPolicyID();
        try {
            $model = $this->repository->findByManyOrFail(['id', 'uuid'], $policyID);
            return $this->output->get(new ACLPolicyGetResponseModel($model));
        } catch (Throwable $exception) {
            if ($exception instanceof ModelNotFoundException) {
                return $this->output->notFound(new ACLPolicyGetResponseModel());
            }
            return $this->output->internalServerError(new ACLPolicyGetResponseModel(), $exception);
        }
    }
}
