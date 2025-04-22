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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('clients');
            $table->decimal('total', 10, 2);
            $table->enum('status', ['recebido', 'em_preparacao', 'pronto', 'finalizado']);
            $table->uuid('token')->unique()->nullable();
            $table->enum('origin', ['totem', 'whatsapp', 'balcao'])->default('totem');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
