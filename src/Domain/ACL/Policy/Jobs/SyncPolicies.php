<?php

namespace ConsulConfigManager\Consul\Domain\ACL\Policy\Jobs;

use Illuminate\Support\Arr;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Consul\Exceptions\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use ConsulConfigManager\Consul\Interfaces\Services\AccessControlListServiceInterface;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Repositories\ACLPolicyRepositoryInterface;

/**
 * Class SyncPolicies
 * @package ConsulConfigManager\Consul\Domain\ACL\Policy\Jobs
 */
class SyncPolicies implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Execute the job.
     * @param AccessControlListServiceInterface $service
     * @param ACLPolicyRepositoryInterface $repository
     * @return void
     * @throws RequestException
     */
    public function handle(AccessControlListServiceInterface $service, ACLPolicyRepositoryInterface $repository): void
    {
        $localPoliciesList = $repository->all(['id'])->pluck('id')->toArray();
        $remotePoliciesList = $service->listPolicies();
        foreach ($remotePoliciesList as $policyInfo) {
            $id = Arr::get($policyInfo, 'id');
            $policy = $service->readPolicy($id);
            if ($repository->find($id)) {
                $repository->update(
                    Arr::get($policy, 'id'),
                    Arr::get($policy, 'name'),
                    Arr::get($policy, 'description'),
                    Arr::get($policy, 'rules'),
                );
            } else {
                $repository->create(
                    Arr::get($policy, 'id'),
                    Arr::get($policy, 'name'),
                    Arr::get($policy, 'description'),
                    Arr::get($policy, 'rules'),
                );
            }
        }

        $remotePoliciesIdentifiers = array_map(function (array $policy): string {
            return Arr::get($policy, 'id');
        }, $remotePoliciesList);

        foreach ($localPoliciesList as $policy) {
            if (!in_array($policy, $remotePoliciesIdentifiers)) {
                $repository->delete($policy);
            }
        }
    }
}
