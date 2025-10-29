<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('researcher_id');
            $table->unsignedBigInteger('lesson_id')->nullable(); // الربط مع الدرس

            $table->string('title');
            $table->string('subject')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->timestamps();

            // المفاتيح الأجنبية
            $table->foreign('researcher_id')->references('id')->on('researchers')->onDelete('cascade');
            $table->foreign('lesson_id')->references('id')->on('lessonss')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('exams');
    }
}
