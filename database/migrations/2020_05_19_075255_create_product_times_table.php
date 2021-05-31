<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_times', function (Blueprint $table) {
            $table->increments('id');
            // todo
            // product_costを持っている
            // 開始時間・終了時間を取得（dateTime型）
            // 終了時間はnullも許容されるように

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
        Schema::dropIfExists('product_times');
    }
}
