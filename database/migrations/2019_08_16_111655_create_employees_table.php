<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->nullable()->comment('ユーザー');
            // todo
            // 名・姓・カナ名・カナ姓を追加
            // 全て文字列型
            $table->string('first_name')->nullable()->comment('名');
            $table->string('last_name')->comment('姓');
            $table->string('first_phonetic_name')->nullable()->comment('カナ名');
            $table->string('last_phonetic_name')->nullable()->comment('カナ姓');
            //$table->boolean('is_admin')->default(0)->comment('権限');
            $table->softDeletes();
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
        Schema::dropIfExists('employees');
    }
}
