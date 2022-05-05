<?php

namespace ConsulConfigManager\Consul\Test\Unit;

use ConsulConfigManager\Consul\ConsulDomain;
use ConsulConfigManager\Consul\Test\TestCase;

/**
 * Class ConsulDomainTest
 *
 * @package ConsulConfigManager\Consul\Test\Unit
 */
class ConsulDomainTest extends TestCase
{
    public function testMigrationsShouldRunByDefault(): void
    {
        $this->assertTrue(ConsulDomain::shouldRunMigrations());
    }

    public function testMigrationsPublishingCanBeDisabled(): void
    {
        ConsulDomain::ignoreMigrations();
        $this->assertFalse(ConsulDomain::shouldRunMigrations());
        ConsulDomain::registerMigrations();
    }

    public function testRoutesShouldNotBeRegisteredByDefault(): void
    {
        ConsulDomain::ignoreRoutes();
        $this->assertFalse(ConsulDomain::shouldRegisterRoutes());
        ConsulDomain::registerRoutes();
    }

    public function testRoutesRegistrationCanBeEnabled(): void
    {
        ConsulDomain::registerRoutes();
        $this->assertTrue(ConsulDomain::shouldRegisterRoutes());
        ConsulDomain::ignoreRoutes();
    }
}
