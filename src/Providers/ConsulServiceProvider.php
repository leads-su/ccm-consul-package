<?php

namespace ConsulConfigManager\Consul\Providers;

use Illuminate\Support\Facades\Route;
use ConsulConfigManager\Consul\ConsulDomain;
use Spatie\EventSourcing\Facades\Projectionist;
use ConsulConfigManager\Consul\Traits\WithMappings;
use ConsulConfigManager\Consul\Commands\KeyValueSync;
use ConsulConfigManager\Consul\Services\AgentService;
use ConsulConfigManager\Domain\DomainServiceProvider;
use ConsulConfigManager\Consul\Services\KeyValueService;
use ConsulConfigManager\Consul\Services\AccessControlListService;
use ConsulConfigManager\Consul\Http\Controllers\ServiceController;
use ConsulConfigManager\Consul\Http\Controllers\ServicesController;
use ConsulConfigManager\Consul\Http\Controllers\ACLPolicyGetController;
use ConsulConfigManager\Consul\Http\Controllers\KeyValueReadController;
use ConsulConfigManager\Consul\Http\Controllers\ACLPolicyListController;
use ConsulConfigManager\Consul\Interfaces\Services\AgentServiceInterface;
use ConsulConfigManager\Consul\Domain\Service\Projectors\ServiceProjector;
use ConsulConfigManager\Consul\Domain\KeyValue\Projectors\KeyValueProjector;
use ConsulConfigManager\Consul\Interfaces\Services\KeyValueServiceInterface;
use ConsulConfigManager\Consul\Http\Controllers\KeyValueNamespacedController;
use ConsulConfigManager\Consul\Http\Controllers\KeyValueReferencesController;
use ConsulConfigManager\Consul\Domain\Service\Presenters\ServiceHttpPresenter;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Projectors\ACLPolicyProjector;
use ConsulConfigManager\Consul\Domain\Service\Presenters\ServicesHttpPresenter;
use ConsulConfigManager\Consul\Domain\Service\UseCases\Service\ServiceInputPort;
use ConsulConfigManager\Consul\Domain\Service\UseCases\Service\ServiceInteractor;
use ConsulConfigManager\Consul\Domain\Service\UseCases\Services\ServicesInputPort;
use ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Read\KeyValueReadInputPort;
use ConsulConfigManager\Consul\Domain\Service\UseCases\Services\ServicesInteractor;
use ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\Get\ACLPolicyGetInputPort;
use ConsulConfigManager\Consul\Domain\KeyValue\Presenters\KeyValueReadHttpPresenter;
use ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Read\KeyValueReadInteractor;
use ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\Get\ACLPolicyGetInteractor;
use ConsulConfigManager\Consul\Interfaces\Services\AccessControlListServiceInterface;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Presenters\ACLPolicyGetHttpPresenter;
use ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\List\ACLPolicyListInputPort;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Presenters\ACLPolicyListHttpPresenter;
use ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\List\ACLPolicyListInteractor;
use ConsulConfigManager\Consul\Domain\KeyValue\Presenters\KeyValueNamespacedHttpPresenter;
use ConsulConfigManager\Consul\Domain\KeyValue\Presenters\KeyValueReferencesHttpPresenter;
use ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Namespaced\KeyValueNamespacedInputPort;
use ConsulConfigManager\Consul\Domain\KeyValue\UseCases\References\KeyValueReferencesInputPort;
use ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Namespaced\KeyValueNamespacedInteractor;
use ConsulConfigManager\Consul\Domain\KeyValue\UseCases\References\KeyValueReferencesInteractor;

/**
 * Class ConsulServiceProvider
 *
 * @package ConsulConfigManager\Consul\Providers
 */
class ConsulServiceProvider extends DomainServiceProvider
{
    use WithMappings;

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        $this->registerRoutes();
        $this->offerPublishing();
        $this->registerMigrations();
        $this->registerCommands();
        parent::boot();
    }

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->registerConfiguration();
        parent::register();
    }

    /**
     * Register package routes
     * @return void
     */
    protected function registerRoutes(): void
    {
        if (ConsulDomain::shouldRegisterRoutes()) {
            Route::group([
                'prefix'        =>  config('domain.consul.prefix'),
                'middleware'    =>  config('domain.consul.middleware'),
            ], function (): void {
                $this->loadRoutesFrom(__DIR__ . '/../../routes/routes.php');
            });
        }
    }

    /**
     * Register package configuration
     * @return void
     */
    protected function registerConfiguration(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/consul.php', 'domain.consul');
    }

    /**
     * Register package migrations
     * @return void
     */
    protected function registerMigrations(): void
    {
        if (ConsulDomain::shouldRunMigrations()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        }
    }

    /**
     * Register package commands
     * @return void
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                KeyValueSync::class,
            ]);
        }
    }

    /**
     * Offer resources for publishing
     * @return void
     */
    protected function offerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/consul.php'     =>  config_path('domain/consul.php'),
            ], 'ccm-consul-config');
            $this->publishes([
                __DIR__ . '/../../database/migrations'  =>  database_path('migrations'),
            ], 'ccm-consul-migrations');
        }
    }


    /**
     * @inheritDoc
     */
    protected function registerFactories(): void
    {
    }

    /**
     * @inheritDoc
     */
    protected function registerRepositories(): void
    {
        foreach ($this->repositoriesMappings() as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * @inheritDoc
     */
    protected function registerInterceptors(): void
    {
        $this->registerInterceptorFromParameters(
            ServicesInputPort::class,
            ServicesInteractor::class,
            ServicesController::class,
            ServicesHttpPresenter::class,
        );

        $this->registerInterceptorFromParameters(
            ServiceInputPort::class,
            ServiceInteractor::class,
            ServiceController::class,
            ServiceHttpPresenter::class,
        );

        $this->registerInterceptorFromParameters(
            KeyValueNamespacedInputPort::class,
            KeyValueNamespacedInteractor::class,
            KeyValueNamespacedController::class,
            KeyValueNamespacedHttpPresenter::class,
        );

        $this->registerInterceptorFromParameters(
            KeyValueReferencesInputPort::class,
            KeyValueReferencesInteractor::class,
            KeyValueReferencesController::class,
            KeyValueReferencesHttpPresenter::class,
        );

        $this->registerInterceptorFromParameters(
            KeyValueReadInputPort::class,
            KeyValueReadInteractor::class,
            KeyValueReadController::class,
            KeyValueReadHttpPresenter::class,
        );

        $this->registerInterceptorFromParameters(
            ACLPolicyListInputPort::class,
            ACLPolicyListInteractor::class,
            ACLPolicyListController::class,
            ACLPolicyListHttpPresenter::class,
        );

        $this->registerInterceptorFromParameters(
            ACLPolicyGetInputPort::class,
            ACLPolicyGetInteractor::class,
            ACLPolicyGetController::class,
            ACLPolicyGetHttpPresenter::class,
        );
    }

    /**
     * @inheritDoc
     */
    protected function registerServices(): void
    {
        $this->app->bind(AccessControlListServiceInterface::class, AccessControlListService::class);
        $this->app->bind(AgentServiceInterface::class, AgentService::class);
        $this->app->bind(KeyValueServiceInterface::class, KeyValueService::class);
    }

    /**
     * @inheritDoc
     */
    protected function registerReactors(): void
    {
//        Projectionist::addReactors([
//
//        ]);
    }

    /**
     * @inheritDoc
     */
    protected function registerProjectors(): void
    {
        Projectionist::addProjectors([
            ACLPolicyProjector::class,
            KeyValueProjector::class,
            ServiceProjector::class,
        ]);
    }
}
