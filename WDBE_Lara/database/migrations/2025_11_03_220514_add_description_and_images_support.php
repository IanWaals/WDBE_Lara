<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add description to products table
        Schema::table('products', function (Blueprint $table) {
            $table->text('description')->nullable()->after('productName');
        });

        // Create product_images table for multiple images
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('image_path');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        // Add foreign key constraint to products-genres relationship
        Schema::table('products', function (Blueprint $table) {
            // Assuming genre column stores genre name, we should ideally have genre_id
            // For now, we'll add it as a new column
            $table->foreignId('genre_id')->nullable()->after('genre')->constrained('genres')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropForeign(['genre_id']);
            $table->dropColumn('genre_id');
        });
        
        Schema::dropIfExists('product_images');
    }
};