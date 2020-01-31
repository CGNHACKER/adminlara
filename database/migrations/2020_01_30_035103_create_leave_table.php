<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('approve_by_role_id')->comment('approver or admin');
            $table->string('reason_leave')->comment('reason leave')->charset('utf8');
            $table->float('date_of_leave');
            $table->float('holiday_of_leave')->comment('holiday of leave');
            $table->integer('leave_category_id');
            $table->date('leave_start');
            $table->date('leave_end');
            $table->enum('is_accept',['0','1','2'])->default('0')->comment('0 = waiting,1 = accept,2 = decline');
            $table->integer('is_accept_by_user_id');
            $table->datetime('status_confirm_date');
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
        Schema::dropIfExists('leave');
    }
}
