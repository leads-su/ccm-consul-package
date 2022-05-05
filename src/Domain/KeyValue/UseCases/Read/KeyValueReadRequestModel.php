<?php

namespace ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Read;

use ConsulConfigManager\Consul\Http\Requests\KeyValueReadRequest;

/**
 * Class KeyValueReadRequestModel
 * @package ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Read
 */
class KeyValueReadRequestModel
{
    /**
     * Request instance
     * @var KeyValueReadRequest
     */
    private KeyValueReadRequest $request;

    /**
     * KeyValueReadRequestModel constructor.
     * @param KeyValueReadRequest $request
     * @return void
     */
    public function __construct(KeyValueReadRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Get request instance
     * @return KeyValueReadRequest
     */
    public function getRequest(): KeyValueReadRequest
    {
        return $this->request;
    }

    /**
     * Get key path
     * @return string
     */
    public function getKey(): string
    {
        return $this->getRequest()->get('key');
    }
}
