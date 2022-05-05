<?php

namespace ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Read;

use Throwable;
use ConsulConfigManager\Domain\Interfaces\ViewModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use ConsulConfigManager\Consul\Domain\KeyValue\Repositories\KeyValueRepositoryInterface;

/**
 * Class KeyValueReadInteractor
 * @package ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Read
 */
class KeyValueReadInteractor implements KeyValueReadInputPort
{
    /**
     * Output port instance
     * @var KeyValueReadOutputPort
     */
    private KeyValueReadOutputPort $output;

    /**
     * Key Value repository instance
     * @var KeyValueRepositoryInterface
     */
    private KeyValueRepositoryInterface $repository;

    /**
     * KeyValueReadInteractor constructor.
     * @param KeyValueReadOutputPort $output
     * @param KeyValueRepositoryInterface $repository
     * @return void
     */
    public function __construct(KeyValueReadOutputPort $output, KeyValueRepositoryInterface $repository)
    {
        $this->output = $output;
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function read(KeyValueReadRequestModel $requestModel): ViewModel
    {
        $key = $requestModel->getKey();
        if ($key === null) {
            return $this->output->missingKey(new KeyValueReadResponseModel());
        }

        try {
            return $this->output->read(new KeyValueReadResponseModel(
                $this->repository->findOrFail($key)
            ));
        } catch (Throwable $exception) {
            if ($exception instanceof ModelNotFoundException) {
                return $this->output->keyNotFound(new KeyValueReadResponseModel());
            }
            return $this->output->internalServerError(new KeyValueReadResponseModel(), $exception);
        }
    }
}
