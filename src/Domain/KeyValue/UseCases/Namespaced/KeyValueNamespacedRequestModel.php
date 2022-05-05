<?php

namespace ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Namespaced;

use Illuminate\Http\Request;

/**
 * Class KeyValueNamespacedRequestModel
 * @package ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Namespaced
 */
class KeyValueNamespacedRequestModel
{
    /**
     * Request instance
     * @var Request
     */
    private Request $request;

    /**
     * KeyValueNamespacedRequestModel constructor.
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
}
