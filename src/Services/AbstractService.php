<?php

namespace ConsulConfigManager\Consul\Services;

use Throwable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Client\PendingRequest;

/**
 * Class AbstractService
 *
 * @package ConsulConfigManager\Consul\Services
 */
abstract class AbstractService
{
    /**
     * HTTP client instance
     * @var PendingRequest
     */
    private PendingRequest $client;

    /**
     * AbstractService Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->initializeClient();
    }

    /**
     * Get instance of HTTP client
     * @return PendingRequest
     */
    public function client(): PendingRequest
    {
        return $this->client;
    }

    /**
     * Initialize consul client
     * @return void
     */
    private function initializeClient(): void
    {
        $activeConnection = $this->getActiveConnection();
        $scheme = Arr::get($activeConnection, 'scheme', 'http');
        $host = Arr::get($activeConnection, 'host', '127.0.0.1');
        $port = Arr::get($activeConnection, 'port', 8500);


        $this->client = Http::baseUrl(sprintf(
            '%s://%s:%d/v1',
            $scheme,
            $host,
            $port,
        ))->withHeaders([
            'X-Consul-Token'    =>  Arr::get($activeConnection, 'access_token') ?? config('domain.consul.access_token', ''),
        ])->timeout(config('domain.consul.timeout', 15));
    }

    /**
     * Get active consul connection
     * @return array
     */
    private function getActiveConnection(): array
    {
        $connectionName = config('domain.consul.default', 'default');
        $connectionsList = config('domain.consul.connections', [
            'default'       =>  [
                'scheme'    =>  'http',
                'host'      =>  '127.0.0.1',
                'port'      =>  8500,
            ],
        ]);

        $withAutoSelect = config('domain.consul.auto_select', false);
        $withRandomServer = config('domain.consul.use_random', false);

        // @codeCoverageIgnoreStart
        if ($withRandomServer) {
            return Arr::random($connectionsList);
        }


        if ($withAutoSelect) {
            if (Cache::has('consul::server:connection')) {
                $connection = Cache::get('consul::server:connection');
                return $connectionsList[$connection];
            }

            $onlineServers = [];
            foreach ($connectionsList as $name => $details) {
                if ($this->serverOnline(
                    Arr::get($details, 'host'),
                    Arr::get($details, 'port'),
                )) {
                    Arr::set($onlineServers, $name, $name);
                }
            }

            $currentServer = Arr::random($onlineServers);
            Cache::set('consul::server:connection', $currentServer);
            return $currentServer;
        }

        // @codeCoverageIgnoreEnd

        return $connectionsList[$connectionName];
    }

    /**
     * Check if requested server is online
     * @param string $host
     * @param int    $port
     *
     * @return bool
     */
    public function serverOnline(string $host, int $port): bool
    {
        $online = false;
        try {
            if ($handle = fsockopen($host, $port, $errorCode, $errorString, 1)) {
                $online = true;
            }
            fclose($handle);
        } catch (Throwable) {
            return false;
        }
        return $online;
    }
}
