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


        Schema::create('categories', function(Blueprint $table){
            $table->id();
            $table->string('category_name');

            $table->timestamps();
        });



        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->decimal('price', 10, 2);
            $table->boolean('active')->default(true);


            $table->foreignId('category_id')->constrained('categories');
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
