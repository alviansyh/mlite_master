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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('material_id')->constrained('materials');
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->string('batch_number');
            $table->date('expired_at')->nullable();
            $table->integer('quantity');
            $table->string('base_unit_code');
            $table->foreign('base_unit_code')->references('code')->on('units');
            $table->unique(['material_id', 'warehouse_id', 'batch_number'], 'inventory_unique_batch');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
