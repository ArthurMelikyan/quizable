<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('text')->nullable();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('quiz_id');
            $table->unsignedBigInteger('question_id')->nullable();
            $table->unsignedBigInteger('answer_id')->nullable();
            $table->unsignedBigInteger('user_quiz_id')->index();

            $table->index(['user_id','question_id']);
            $table->unsignedBigInteger('quiz_report_id')->nullable()->index();
            $table->timestamps();

            $table->foreign('quiz_id')->on('quizes')->references('id')->onDelete('cascade');
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('question_id')->on('questions')->references('id')->onDelete('cascade');
            $table->foreign('answer_id')->on('answers')->references('id')->onDelete('cascade');
            $table->foreign('user_quiz_id')->on('user_quizes')->references('id')->onDelete('cascade');
            $table->foreign('quiz_report_id')->on('quiz_reports')->references('id')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_answers');
    }
}
