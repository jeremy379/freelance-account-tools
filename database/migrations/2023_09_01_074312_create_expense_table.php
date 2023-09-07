<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expense', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('category')->index();
            $table->string('provider')->index();
            $table->unsignedBigInteger('amount');
            $table->string('tax_rate');
            $table->string('country_code');
            $table->timestamps();
        });
    }
};
