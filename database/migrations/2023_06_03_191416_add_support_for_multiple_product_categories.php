<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function ($table) {
            $table->dropConstrainedForeignId('product_category_id');
        });

        Schema::create('product_product_category', function ($table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('product_id')
                ->constrained();
            $table->foreignId('product_category_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_product_category');

        Schema::table('products', function ($table) {
            $table->foreignId('product_category_id')->nullable()->constrained();
        });
    }
};
