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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->nullable();
            $table->string('description')->nullable();
            $table->string('code')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('variant')->nullable();
            $table->string('image')->nullable();
            $table->integer('quantity')->default(0);
            $table->decimal('unit_cost')->default(0.00);
            $table->decimal('total_cost')->default(0.00);
            $table->decimal('unit_price')->default(0.00);
            $table->date('expiry')->default(now('Asia/Manila'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
