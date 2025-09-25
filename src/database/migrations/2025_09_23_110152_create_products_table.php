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
            $table->integer('price');
            $table->string('image_path');                   // 画像パス
            $table->boolean('is_my_like')->default(false);  //自分が いいね した商品
            $table->boolean('is_sold')->default(false);     //購入済の商品
            $table->unsignedInteger('like_count');          //いいね の数
            $table->unsignedInteger('comment_count');       //コメント の数
            $table->string('brand', 255);
            $table->string('description', 255);
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('condition_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
