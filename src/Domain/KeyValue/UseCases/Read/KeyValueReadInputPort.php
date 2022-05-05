<?php

namespace ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Read;

use ConsulConfigManager\Domain\Interfaces\ViewModel;

/**
 * Interface KeyValueReadInputPort
 * @package ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Read
 */
interface KeyValueReadInputPort
{
    /**
     * @param KeyValueReadRequestModel $requestModel
     * @return ViewModel
     */
    public function read(KeyValueReadRequestModel $requestModel): ViewModel;
}
