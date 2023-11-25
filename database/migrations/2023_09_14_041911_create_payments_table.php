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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('sales_invoice_number')->nullable();
            // $table->foreignId('purchase_order_id')->nullable()->constrained('purchase_oder')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('sales_order_id')->nullable()->constrained('sales_order')->nullOnDelete()->cascadeOnUpdate();
            $table->decimal('sales_total_amount')->default('0.00');
            $table->decimal('paid_amount')->default('0.00');
            $table->enum('method', ['cash', 'e-wallet', 'cod'])->default('cash');
            $table->enum('status', ['preparing', 'paid', 'unpaid', 'partially paid', 'fully paid'])->default('preparing');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
