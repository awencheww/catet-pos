<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_order', function (Blueprint $table) {
            $table->id();
            $table->integer('po_number')->unique()->unsigned()->autoIncrement();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->integer('quantity')->default(0);
            $table->decimal('unit_cost')->default(0.00);
            $table->decimal('unit_price')->default(0.00);
            $table->string('po_status')->default('received');
            $table->string('po_note')->nullable();
            $table->date('purchase_date')->default(now('Asia/Manila'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order');
    }
};
