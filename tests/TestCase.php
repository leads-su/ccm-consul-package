<?php

namespace ConsulConfigManager\Consul\Test;

use ConsulConfigManager\Testing\Concerns;
use ConsulConfigManager\Consul\ConsulDomain;
use Spatie\EventSourcing\EventSourcingServiceProvider;
use ConsulConfigManager\Consul\Providers\ConsulServiceProvider;

/**
 * Class TestCase
 *
 * @package ConsulConfigManager\Consul\Test
 */
abstract class TestCase extends \ConsulConfigManager\Testing\TestCase
{
    use Concerns\WithQueueMigrations;
    use Concerns\WithEventSourcingMigrations;

    /**
     * @inheritDoc
     */
    protected array $packageProviders = [
        EventSourcingServiceProvider::class,
        ConsulServiceProvider::class,
    ];

    /**
     * @inheritDoc
     */
    protected bool $configurationFromEnvironment = true;

    /**
     * @inheritDoc
     */
    protected string $configurationFromFile = __DIR__ . '/..';


    /**
     * @inheritDoc
     */
    public function runBeforeSetUp(): void
    {
        ConsulDomain::registerRoutes();
    }

    /**
     * @inheritDoc
     */
    public function runBeforeTearDown(): void
    {
        ConsulDomain::ignoreRoutes();
    }

    /**
     * @inheritDoc
     */
    public function setUpEnvironment($app): void
    {
        $this->setConfigurationValue('domain.consul', [
                'emulate'           =>  env('CONSUL_SERVER_EMULATE', false),
                'default'           =>  env('CONSUL_SERVER_CONNECTION', 'default'),
                'auto_select'       =>  env('CONSUL_SERVER_AUTO_SELECT', false),
                'use_random'        =>  env('CONSUL_SERVER_USE_RANDOM', false),
                'datacenter'        =>  env('CONSUL_SERVER_DATACENTER', 'dc0'),
                'access_token'      =>  env('CONSUL_SERVER_TOKEN', ''),
                'connections'       =>  [
                    'default'       =>  [
                        'scheme'        =>  env('CONSUL_SERVER_SCHEME', 'http'),
                        'host'          =>  env('CONSUL_SERVER_HOST', '127.0.0.1'),
                        'port'          =>  env('CONSUL_SERVER_PORT', 8500),
                    ],
                ],
                'system_user'           =>  [
                    'email'             =>  env('CONSUL_SYSTEM_USER_EMAIL', 'admin@leads.su'),
                    'password'          =>  env('CONSUL_SYSTEM_USER_PASSWORD', '1234567890'),
                ],
                'prefix'                =>  'consul',
                'middleware'            =>  [
                    'api',
                ],
            ], $app);

        $this->setConfigurationValue(
            'event-sourcing.snapshot_repository',
            \Spatie\EventSourcing\Snapshots\EloquentSnapshotRepository::class,
            $app
        );

        $this->setConfigurationValue(
            'event-sourcing.stored_event_repository',
            \Spatie\EventSourcing\StoredEvents\Repositories\EloquentStoredEventRepository::class,
            $app
        );

    }

}
