<?php

namespace ConsulConfigManager\Consul\Jobs;

use Illuminate\Support\Arr;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Consul\Exceptions\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use ConsulConfigManager\Consul\Interfaces\Services\AgentServiceInterface;
use ConsulConfigManager\Consul\Domain\Service\Repositories\ServiceRepositoryInterface;

/**
 * Class RefreshConsulServicesListJob
 * @package ConsulConfigManager\Consul\Jobs
 */
class RefreshConsulServicesListJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Execute the job.
     * @param AgentServiceInterface $service
     * @param ServiceRepositoryInterface $repository
     * @return void
     * @throws RequestException
     */
    public function handle(AgentServiceInterface $service, ServiceRepositoryInterface $repository): void
    {
        $localServicesList = $repository->all()->pluck('identifier')->toArray();
        $remoteServicesList = $service->listServices();
        foreach ($remoteServicesList as $service) {
            $identifier = Arr::get($service, 'id');
            Arr::set($service, 'online', true);
            if ($repository->find($identifier)) {
                $repository->update($service);
            } else {
                $repository->create($service);
            }
        }

        $remoteServicesIdentifiers = array_keys($remoteServicesList);
        foreach ($localServicesList as $service) {
            if (!in_array($service, $remoteServicesIdentifiers)) {
                $repository->update([
                    'id'        =>  $service,
                    'online'    =>  false,
                ]);
            }
        }
    }
}
