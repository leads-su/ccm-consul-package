<?php

namespace ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\List;

use Throwable;
use ConsulConfigManager\Domain\Interfaces\ViewModel;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Repositories\ACLPolicyRepositoryInterface;

/**
 * Class ACLPolicyListInteractor
 * @package ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\List
 */
class ACLPolicyListInteractor implements ACLPolicyListInputPort
{
    /**
     * Output port instance
     * @var ACLPolicyListOutputPort
     */
    private ACLPolicyListOutputPort $output;

    /**
     * Repository instance
     * @var ACLPolicyRepositoryInterface
     */
    private ACLPolicyRepositoryInterface $repository;

    /**
     * ACLPolicyListInteractor constructor.
     * @param ACLPolicyListOutputPort $output
     * @param ACLPolicyRepositoryInterface $repository
     * @return void
     */
    public function __construct(ACLPolicyListOutputPort $output, ACLPolicyRepositoryInterface $repository)
    {
        $this->output = $output;
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function list(ACLPolicyListRequestModel $requestModel): ViewModel
    {
        try {
            $policies = $this->repository->all([
                'id', 'uuid',
                'name', 'description',
                'created_at', 'updated_at',
            ])->toArray();
            return $this->output->list(new ACLPolicyListResponseModel($policies));
        } catch (Throwable $exception) {
            return $this->output->internalServerError(new ACLPolicyListResponseModel(), $exception);
        }
    }
}
