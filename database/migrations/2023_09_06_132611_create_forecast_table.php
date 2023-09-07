<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forecast', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('category')->nullable();
            $table->unsignedBigInteger('amount');
            $table->integer('vat_rate');
            $table->dateTime('forecasted_on');
            $table->string('country_code')->nullable();
            $table->timestamps();
        });
    }
};
