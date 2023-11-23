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
        Schema::create('sales_order', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_number')->unique()->unsigned()->autoIncrement();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->integer('quantity')->default(0);
            $table->decimal('price')->default(0.00);
            $table->decimal('total_amount')->default(0.00);
            $table->decimal('discount')->default(0.00);
            $table->decimal('net_total')->default(0.00);
            $table->integer('sugar_content')->nullable();
            $table->string('custom_name');
            $table->string('so_status')->default('delivered');
            $table->string('so_note')->nullable();
            $table->date('sales_date')->default(now('Asia/Manila'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order');
    }
};
