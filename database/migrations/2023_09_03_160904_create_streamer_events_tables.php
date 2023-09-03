<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('followers', function (Blueprint $table) {
            $this->sharedEventColumns($table);
            $table->unsignedBigInteger('follower_id');
            $table->softDeletes();

            $table->foreign('follower_id')->references('id')->on('users');
        });

        //
        Schema::create('subscription_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('amount');
            $this->currencyColumn($table);
        });
        Schema::create('subscribers', function (Blueprint $table) {
            $this->sharedEventColumns($table);
            $table->unsignedBigInteger('subscriber_id');
            $table->unsignedBigInteger('subscription_tier_id');

            $table->foreign('subscriber_id')->references('id')->on('users');
            $table->foreign('subscription_tier_id')->references('id')->on('subscription_tiers');
        });

        //
        Schema::create('donations', function (Blueprint $table) {
            $this->sharedEventColumns($table);
            $table->string('message');
            $table->unsignedBigInteger('amount');
            $this->currencyColumn($table);
        });

        //

        Schema::create('merchandises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('price');
            $this->currencyColumn($table);
        });

        Schema::create('merchandise_sales', function (Blueprint $table) {
            $this->sharedEventColumns($table);
            $table->foreignId('merchandise_id')->constrained();
            $table->unsignedSmallInteger('amount'); // TODO: validate count
        });
    }

    private function sharedEventColumns(Blueprint $table): void
    {
        $table->id();
        $table->foreignId('user_id')->constrained();
        $table->timestamp('created_at');
        $table->boolean('is_read');
    }

    private function currencyColumn(Blueprint $table): void
    {
        $table->string('currency', 3);
    }

    public function down(): void
    {
        throw new Exception('Rollback is disabled');
    }
};
