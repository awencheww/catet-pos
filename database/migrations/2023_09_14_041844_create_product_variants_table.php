<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Delimiter\Delimiter;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('product')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('variant_name');
            $table->string('product_serial')->nullable();
            $table->integer('quantity')->default(0);
            $table->decimal('unit_cost')->default(0.00);
            $table->decimal('unit_price')->default(0.00);
            $table->date('date_expire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
