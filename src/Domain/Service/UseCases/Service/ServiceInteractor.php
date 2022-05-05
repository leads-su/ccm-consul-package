<?php

namespace ConsulConfigManager\Consul\Domain\Service\UseCases\Service;

use Throwable;
use ConsulConfigManager\Domain\Interfaces\ViewModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use ConsulConfigManager\Consul\Domain\Service\Repositories\ServiceRepositoryInterface;

/**
 * Class ServiceInteractor
 * @package ConsulConfigManager\Consul\Domain\Service\UseCases\Service
 */
class ServiceInteractor implements ServiceInputPort
{
    /**
     * Output port instance
     * @var ServiceOutputPort
     */
    private ServiceOutputPort $output;

    /**
     * Service repository instance
     * @var ServiceRepositoryInterface
     */
    private ServiceRepositoryInterface $repository;

    /**
     * ServiceInteractor constructor.
     * @param ServiceOutputPort $output
     * @param ServiceRepositoryInterface $repository
     */
    public function __construct(ServiceOutputPort $output, ServiceRepositoryInterface $repository)
    {
        $this->output = $output;
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function service(ServiceRequestModel $serviceRequestModel): ViewModel
    {
        $identifier = $serviceRequestModel->getIdentifier();

        if ($identifier === null) {
            return $this->output->missingIdentifier(new ServiceResponseModel());
        }

        try {
            return $this->output->serviceInformation(new ServiceResponseModel(
                $this->repository->findOrFail($identifier)
            ));
        } catch (Throwable $exception) {
            if ($exception instanceof ModelNotFoundException) {
                return $this->output->serviceNotFound(new ServiceResponseModel());
            }
            return $this->output->internalServerError(new ServiceResponseModel(), $exception);
        }
    }
}
