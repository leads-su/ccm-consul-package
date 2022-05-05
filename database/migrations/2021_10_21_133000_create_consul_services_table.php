<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateConsulServicesTable
 */
class CreateConsulServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('consul_services', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('identifier');
            $table->string('service');
            $table->string('address');
            $table->integer('port');
            $table->string('datacenter');
            $table->json('tags');
            $table->json('meta');
            $table->boolean('online')->default(false);
            $table->string('environment')->default('development');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('consul_services');
    }
}
