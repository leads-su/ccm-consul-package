<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateConsulKeyValuesTable
 */
class CreateConsulKeyValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('consul_key_values', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->text('path');
            $table->json('value');
            $table->boolean('reference')->default(false);
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
        Schema::dropIfExists('consul_key_values');
    }
}
