<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('address')->nullable();
            $table->string('link_admin')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('password_admin');
            $table->string('link_services')->nullable();
            $table->string('link_lookup')->nullable();
            $table->string('username_services')->nullable();
            $table->string('password_services')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('role')->nullable();
            $table->integer('status')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
