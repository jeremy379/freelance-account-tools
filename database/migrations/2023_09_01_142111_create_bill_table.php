<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bill', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('client')->index();
            $table->unsignedBigInteger('amount');
            $table->unsignedInteger('tax_rate');
            $table->dateTime('billing_datetime');
            $table->timestamps();
        });
    }
};
