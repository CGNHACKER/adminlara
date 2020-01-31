<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_th',50)->charset('utf8');
            $table->string('name_en',50)->charset('utf8');
            $table->string('leave_unit',10)->charset('utf8');
            $table->enum('is_active',['0','1'])->default('1');
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
        Schema::dropIfExists('leave_category');
    }
}
