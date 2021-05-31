<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_costs', function (Blueprint $table) {
            $table->increments('id');
            // todo
            // 作業日（型は日付）
            
            // ラインNo.・順番・品目（文字列型）

            // C/T(min)　小数第3位まで表示させる
            
            // 納入指示日（日付型）
            $table->date('deliveried_on')->nullable()->comment('納入指示日');
            // 指示数・納入指示数・製作数量（数値型）

            $table->json('state')->nullable()->comment('状態');
            // 完了してるかどうかのフラグを追加(true/falseで判定できるように)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_costs');
    }
}
