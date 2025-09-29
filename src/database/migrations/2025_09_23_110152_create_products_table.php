<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');                         // 商品名
            $table->foreignId('condition_id')->constrained()->cascadeOnDelete();
            $table->integer('price');
            $table->string('image_path');                   // 画像パス
            $table->string('brand', 255);
            $table->string('description', 255);
            $table->foreignId('seller_id')->nullable()->constrained('users')->nullOnDelete();  // 出品者ID
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
