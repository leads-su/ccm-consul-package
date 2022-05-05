<?php

namespace ConsulConfigManager\Consul\Domain\Service\UseCases\Services;

use Illuminate\Support\Collection;

/**
 * Class ServicesResponseModel
 * @package ConsulConfigManager\Consul\Domain\Service\UseCases\Services
 */
class ServicesResponseModel
{
    /**
     * Services collection instance
     * @var Collection|null
     */
    private ?Collection $collection;

    /**
     * ServicesResponseModel constructor.
     * @param Collection|null $collection
     * @return void
     */
    public function __construct(?Collection $collection = null)
    {
        $this->collection = $collection;
    }

    /**
     * Get collection of services
     * @return Collection|null
     */
    public function getCollection(): ?Collection
    {
        return $this->collection;
    }
}
