<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->timestamp('created_at');
            $table->boolean('read');
            $table->unsignedBigInteger('follower_id');
            $table->softDeletes();

            $table->foreign('follower_id')->references('id')->on('users');
            $table->unique(['user_id', 'follower_id']);
        });

        //
        Schema::create('subscription_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('amount');
            $table->string('currency', 3);
        });
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at');
            $table->foreignId('user_id');
            $table->boolean('read');
            $table->unsignedBigInteger('subscriber_id');
            $table->unsignedBigInteger('subscription_tier_id');

            $table->foreign('subscriber_id')->references('id')->on('users');
            $table->foreign('subscription_tier_id')->references('id')->on('subscription_tiers');
        });

        //
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->timestamp('created_at');
            $table->boolean('read');
            $table->string('message');
            $table->string('currency', 3);
        });

        //

        Schema::create('merchandises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('price');
            $table->string('currency', 3);
        });

        Schema::create('merchandise_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->timestamp('created_at');
            $table->boolean('read');
            $table->foreignId('merchandise_id')->constrained();
            $table->unsignedSmallInteger('amount'); // TODO: validate count
        });
    }

    public function down(): void
    {
        throw new Exception('Rollback is disabled');
    }
};
