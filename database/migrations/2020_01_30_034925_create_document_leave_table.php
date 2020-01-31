<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentLeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_leave', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('leave_id');
            $table->string('document_name_show',200)->charset('utf8');
            $table->string('document_name_save',200)->charset('utf8');
            $table->string('document_path')->charset('utf8');
            $table->string('document_type',20)->charset('utf8');
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
        Schema::dropIfExists('document_leave');
    }
}
