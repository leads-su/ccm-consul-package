<?php

namespace ConsulConfigManager\Consul\Services;

use Consul\Services\Agent\Agent;
use Consul\Exceptions\RequestException;
use ConsulConfigManager\Consul\Interfaces\Services\AgentServiceInterface;

/**
 * Class AgentService
 *
 * @package ConsulConfigManager\Consul\Services
 */
class AgentService extends AbstractService implements AgentServiceInterface
{
    /**
     * SDK service reference
     * @var Agent
     */
    private Agent $service;

    /**
     * AgentService Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->service = new Agent($this->client());
    }

    /**
     * @inheritDoc
     */
    public function host(): array
    {
        return (new ResponseTransformerService($this->service->host()))
            ->mapKeys([
                'CPU'           =>  'cpu',
                'committedAS'   =>  'committedAs',
            ])
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function members(bool $wan = false): array
    {
        return (new ResponseTransformerService($this->service->members($wan)))
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function self(): array
    {
        return (new ResponseTransformerService($this->service->self()))
            ->mapContains([
                'HTTPS'     =>  'Https',
                'HTTP'      =>  'Http',
                'ACL'       =>  'Acl',
                'DNS'       =>  'Dns',
                'SOA'       =>  'Soa',
                'TXT'       =>  'Txt',
                'GRPC'      =>  'Grpc',
                'RPC'       =>  'Rpc',
                'JSON'      =>  'Json',
                'TTL'       =>  'Ttl',
                'TLS'       =>  'Tls',
                'SAN'       =>  'San',
                'WAN'       =>  'Wan',
                'LAN'       =>  'Lan',
                'URL'       =>  'Url',
                'JWT'       =>  'Jwt',
                'API'       =>  'Api',
                'UDP'       =>  'Udp',
                'TCP'       =>  'Tcp',
                'CIDR'      =>  'Cidr',
                'JWKS'      =>  'Jwks',
                'OIDC'      =>  'Oidc',
                'IP'        =>  'Ip',
                'CA'        =>  'Ca',
            ])
            ->mapKeysStartingWith([
                'AE'        =>  'Ae',
                'UI'        =>  'Ui',
                'KV'        =>  'Kv',
            ])
            ->mapKeysEndingWith([
                'ID'        =>  'Id',
            ])
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function metrics(bool $forPrometheus = false): array
    {
        return (new ResponseTransformerService($this->service->metrics($forPrometheus)))
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function registerCheck(array $options = []): bool
    {
        try {
            $this->service->registerCheck($options);
            return true;
        } catch (RequestException) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function deRegisterCheck(string $checkID): bool
    {
        try {
            $this->service->deRegisterCheck($checkID);
            return true;
        } catch (RequestException) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function ttlCheckPass(string $checkID, string $note = ''): bool
    {
        try {
            $this->service->ttlCheckPass($checkID, $note);
            return true;
        } catch (RequestException) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function ttlCheckFail(string $checkID, string $note = ''): bool
    {
        try {
            $this->service->ttlCheckFail($checkID, $note);
            return true;
        } catch (RequestException) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function ttlCheckWarn(string $checkID, string $note = ''): bool
    {
        try {
            $this->service->ttlCheckWarn($checkID, $note);
            return true;
        } catch (RequestException) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function listChecks(string $filter = ''): array
    {
        return (new ResponseTransformerService($this->service->listChecks($filter)))
            ->mapContains([
                'TTL'       =>  'Ttl',
                'ID'        =>  'Id',
            ])
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function registerService(array $options = []): bool
    {
        try {
            $this->service->registerService($options);
            return true;
        } catch (RequestException) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function deRegisterService(string $serviceID): bool
    {
        try {
            $this->service->deRegisterService($serviceID);
            return true;
        } catch (RequestException) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function toggleMaintenanceMode(string $serviceID, bool $enabled, string $reason = ''): bool
    {
        try {
            $this->service->toggleMaintenanceMode($serviceID, $enabled, $reason);
            return true;
        } catch (RequestException) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function serviceConfiguration(string $serviceID): array
    {
        return (new ResponseTransformerService($this->service->serviceConfiguration($serviceID)))
            ->mapContains([
                'ID'    =>  'Id',
            ])
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function localServiceHealth(string $serviceName): array
    {
        return (new ResponseTransformerService($this->service->localServiceHealth($serviceName)))
            ->mapContains([
                'ID'        =>  'Id',
            ])
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function localServiceHealthByID(string $serviceID): array
    {
        return (new ResponseTransformerService($this->service->localServiceHealthByID($serviceID)))
            ->mapContains([
                'ID'        =>  'Id',
            ])
            ->getFormattedResponse();
    }

    /**
     * @inheritDoc
     */
    public function listServices(string $filter = ''): array
    {
        return (new ResponseTransformerService($this->service->listServices($filter)))
            ->mapContains([
                'ID'        =>  'Id',
            ])
            ->getFormattedResponse();
    }
}
