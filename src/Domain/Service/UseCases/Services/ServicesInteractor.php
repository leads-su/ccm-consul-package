<?php

namespace ConsulConfigManager\Consul\Domain\Service\UseCases\Services;

use Throwable;
use Illuminate\Support\Arr;
use ConsulConfigManager\Consul\Models\Service;
use ConsulConfigManager\Domain\Interfaces\ViewModel;
use ConsulConfigManager\Consul\Domain\Service\UseCases\Service\ServiceRequestModel;
use ConsulConfigManager\Consul\Domain\Service\Repositories\ServiceRepositoryInterface;

/**
 * Class ServicesInteractor
 * @package ConsulConfigManager\Consul\Domain\Service\UseCases\Services
 */
class ServicesInteractor implements ServicesInputPort
{
    /**
     * Output port instance
     * @var ServicesOutputPort
     */
    private ServicesOutputPort $output;

    /**
     * Service repository instance
     * @var ServiceRepositoryInterface
     */
    private ServiceRepositoryInterface $repository;

    /**
     * ServiceInteractor constructor.
     * @param ServicesOutputPort $output
     * @param ServiceRepositoryInterface $repository
     */
    public function __construct(ServicesOutputPort $output, ServiceRepositoryInterface $repository)
    {
        $this->output = $output;
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function services(ServiceRequestModel $serviceRequestModel): ViewModel
    {
        try {
            return $this->output->services(new ServicesResponseModel(
                $this->repository->all()->map(function (Service $service): array {
                    $serviceArray = $service->toArray();
                    $meta = $service->getMeta();
                    Arr::set($serviceArray, 'version', Arr::get($meta, 'application_version'));
                    Arr::forget($serviceArray, 'meta');
                    return Arr::except($serviceArray, [
                        'deleted_at',
                        'tags',
                    ]);
                })
            ));
        } catch (Throwable $exception) {
            return $this->output->internalServerError(new ServicesResponseModel(), $exception);
        }
    }
}
