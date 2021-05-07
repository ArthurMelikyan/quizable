<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTextToQuizAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_answers', function (Blueprint $table) {
            $table->unsignedBigInteger('user_quiz_id')->index()->after('id');
            $table->unsignedBigInteger('answer_id')->nullable()->change();
            $table->unsignedBigInteger('question_id')->nullable()->change();
            $table->text('text')->after('answer_id')->nullable();
            $table->dropColumn(['user_id', 'quiz_id']);
            $table->dropSoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quiz_answers', function (Blueprint $table) {
            $table->unsignedBigInteger('answer_id')->change();
            $table->unsignedBigInteger('question_id')->change();
            $table->dropColumn('quiz_answers');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('quiz_id');
            $table->softDeletes();
        });
    }
}
