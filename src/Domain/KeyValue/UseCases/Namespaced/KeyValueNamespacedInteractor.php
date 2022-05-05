<?php

namespace ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Namespaced;

use Throwable;
use ConsulConfigManager\Domain\Interfaces\ViewModel;
use ConsulConfigManager\Consul\Domain\KeyValue\Repositories\KeyValueRepositoryInterface;

/**
 * Class KeyValueNamespacedInteractor
 * @package ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Namespaced
 */
class KeyValueNamespacedInteractor implements KeyValueNamespacedInputPort
{
    /**
     * Output port instance
     * @var KeyValueNamespacedOutputPort
     */
    private KeyValueNamespacedOutputPort $output;

    /**
     * Key Value repository instance
     * @var KeyValueRepositoryInterface
     */
    private KeyValueRepositoryInterface $repository;

    /**
     * KeyValueInteractor constructor.
     * @param KeyValueNamespacedOutputPort $output
     * @param KeyValueRepositoryInterface $repository
     * @return void
     */
    public function __construct(KeyValueNamespacedOutputPort $output, KeyValueRepositoryInterface $repository)
    {
        $this->output = $output;
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function namespaced(KeyValueNamespacedRequestModel $requestModel): ViewModel
    {
        try {
            return $this->output->namespaced(new KeyValueNamespacedResponseModel(
                $this->repository->allNamespaced()
            ));
        } catch (Throwable $exception) {
            return $this->output->internalServerError(
                new KeyValueNamespacedResponseModel(),
                $exception
            );
        }
    }
}
