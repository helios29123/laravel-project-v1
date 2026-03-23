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
        Schema::create('variant_attribute_values', function (Blueprint $table) {
            $table->unsignedBigInteger('product_variant_id');
            $table->unsignedBigInteger('attribute_value_id');
            $table->timestamps();

            $table->primary(['product_variant_id', 'attribute_value_id']);

            $table->foreign('product_variant_id', 'fk_vav_product_variant')->references('product_variant_id')->on('product_variants')->onDelete('cascade');
            $table->foreign('attribute_value_id', 'fk_vav_attribute_value')->references('attribute_value_id')->on('attribute_values')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_attribute_values');
    }
};
