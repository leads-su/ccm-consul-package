<?php

use Illuminate\Support\Facades\Route;

Route::get('services', \ConsulConfigManager\Consul\Http\Controllers\ServicesController::class)
    ->name('domain.consul.services');

Route::get('service/{identifier}', \ConsulConfigManager\Consul\Http\Controllers\ServiceController::class)
    ->name('domain.consul.service.information');

Route::prefix('kv')->group(static function (): void {
    Route::get('references', \ConsulConfigManager\Consul\Http\Controllers\KeyValueReferencesController::class)
        ->name('domain.consul.kv.references');
    Route::get('namespaced', \ConsulConfigManager\Consul\Http\Controllers\KeyValueNamespacedController::class)
        ->name('domain.consul.kv.namespaced');
    Route::get('read', \ConsulConfigManager\Consul\Http\Controllers\KeyValueReadController::class)
        ->name('domain.consul.kv.read');
});

Route::prefix('acl')->group(static function (): void {
    Route::prefix('policies')->group(static function (): void {
        Route::name('domain.consul.acl.policies.list')
            ->get('', \ConsulConfigManager\Consul\Http\Controllers\ACLPolicyListController::class);
        Route::name('domain.consul.acl.policies.information')
            ->get('{policy}', \ConsulConfigManager\Consul\Http\Controllers\ACLPolicyGetController::class);
    });
});
