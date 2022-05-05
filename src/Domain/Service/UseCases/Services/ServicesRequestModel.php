<?php

namespace ConsulConfigManager\Consul\Domain\Service\UseCases\Services;

use Illuminate\Http\Request;
use ConsulConfigManager\Users\Interfaces\UserInterface;

/**
 * Class ServicesRequestModel
 * @package ConsulConfigManager\Consul\Domain\Service\UseCases\Services
 */
class ServicesRequestModel
{
    /**
     * Request instance
     * @var Request
     */
    private Request $request;

    /**
     * ServiceRequestModel constructor.
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get request instance
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Get user who made this request
     * @return UserInterface|null
     */
    public function getUser(): ?UserInterface
    {
        return $this->getRequest()->user();
    }
}
