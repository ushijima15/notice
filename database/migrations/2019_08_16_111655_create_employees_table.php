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
            $table->nullable()->string('名');
            $table->string('姓');
            $table->nullable()->->string('カナ名');
            $table->nullable()->->string('カナ性');
            $table->unsignedinteger('position')->nullable();
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
