<?php

namespace ConsulConfigManager\Consul\Domain\Service\UseCases\Service;

use Illuminate\Http\Request;
use ConsulConfigManager\Users\Interfaces\UserInterface;

/**
 * Class ServiceRequestModel
 * @package ConsulConfigManager\Consul\Domain\Service\UseCases\Service
 */
class ServiceRequestModel
{
    /**
     * Request instance
     * @var Request
     */
    private Request $request;

    /**
     * Service identifier
     * @var string|null
     */
    private ?string $identifier;

    /**
     * ServiceRequestModel constructor.
     * @param Request $request
     * @param string|null $identifier
     */
    public function __construct(Request $request, ?string $identifier = null)
    {
        $this->request = $request;
        $this->identifier = $identifier;
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
     * Get service identifier
     * @return string|null
     */
    public function getIdentifier(): ?string
    {
        return $this->identifier;
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
