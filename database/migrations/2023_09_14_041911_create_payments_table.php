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
            $table->foreignId('sales_order_id')->nullable()->constrained('sales_order')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('purchase_order_id')->nullable()->constrained('purchase_order')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->enum('method', ['cash', 'e-wallet', 'cod'])->default('cash');
            $table->enum('status', ['paid', 'unpaid', 'partially paid', 'fully paid'])->default('paid');
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
