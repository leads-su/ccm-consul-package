<?php

namespace ConsulConfigManager\Consul\Domain\KeyValue\UseCases\References;

use Throwable;
use ConsulConfigManager\Domain\Interfaces\ViewModel;
use ConsulConfigManager\Consul\Domain\KeyValue\Repositories\KeyValueRepositoryInterface;

/**
 * Class KeyValueReferencesInteractor
 * @package ConsulConfigManager\Consul\Domain\KeyValue\UseCases\References
 */
class KeyValueReferencesInteractor implements KeyValueReferencesInputPort
{
    /**
     * Output port instance
     * @var KeyValueReferencesOutputPort
     */
    private KeyValueReferencesOutputPort $output;

    /**
     * Key Value repository instance
     * @var KeyValueRepositoryInterface
     */
    private KeyValueRepositoryInterface $repository;

    /**
     * KeyValueInteractor constructor.
     * @param KeyValueReferencesOutputPort $output
     * @param KeyValueRepositoryInterface $repository
     * @return void
     */
    public function __construct(KeyValueReferencesOutputPort $output, KeyValueRepositoryInterface $repository)
    {
        $this->output = $output;
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function references(KeyValueReferencesRequestModel $requestModel): ViewModel
    {
        try {
            return $this->output->references(new KeyValueReferencesResponseModel(
                $this->repository->references()
            ));
        } catch (Throwable $exception) {
            return $this->output->internalServerError(
                new KeyValueReferencesResponseModel(),
                $exception
            );
        }
    }
}
