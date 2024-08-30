<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tokenId');
            $table->string('artName');
            $table->double('price');
            $table->text('owner');
            $table->text('address');
            $table->integer('postalCode');
            $table->string('deliveryNumber')->default('');
            $table->enum('status', ['pending', 'sending', 'done'])->default('pending');
            $table->enum('withdraw', ['pending', 'done']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
