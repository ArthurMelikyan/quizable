<?php

namespace Arthurmelikyan\Quizable\Http\Controllers;


use App\Http\Controllers\Controller;
use Arthurmelikyan\Quizable\Http\Requests\ChangeAnswerOrderRequest;
use Arthurmelikyan\Quizable\Http\Requests\CreateAnswerRequest;
use Arthurmelikyan\Quizable\Http\Requests\UpdateAnswerRequest;
use Arthurmelikyan\Quizable\Http\Resources\AnswerResource;
use Arthurmelikyan\Quizable\Http\Resources\QuestionResource;
use Arthurmelikyan\Quizable\Models\Question;
use Arthurmelikyan\Quizable\Models\Answer;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Arthurmelikyan\Quizable\Helpers\HelperRepo;

class AnswerController extends Controller
{
    public function createAnswer(CreateAnswerRequest $request, int $question_id): JsonResource
    {
        $this->checkIfExistsQuestion($question_id);

        collect($request->data)->each(function ($item) use ($question_id) {

            $item = $item + ['question_id' => $question_id];

            $answer = Answer::create(Arr::except($item, ['file']));

            if (Arr::exists($item, 'file')) {
                $answer->file = HelperRepo::upload_image($item['file'],"answers/$answer->id",[1600 => null]);
                $answer->save();
            }
        });

        $answers = Answer::where('question_id', $question_id)->orderBy('order', 'asc')->get();

        return AnswerResource::collection($answers);
    }

    public function retrieveOneByID(int $question_id, int $answer_id): JsonResource
    {
        $this->checkIfExistsQuestion($question_id, $answer_id);

        $answer = $this->checkIfExistsAnswer($answer_id);

        return AnswerResource::make($answer);
    }


    public function updateAnswer(UpdateAnswerRequest $request, int $question_id)
    {
        collect($request->data)->each(function ($item) use ($question_id) {

            $arr = [
                'title' => '',
                'is_right' => false,
                'file' => null,
                'file_type' => null,
                'url' => null
            ];

            $this->checkIfExistsQuestion($question_id, $item['id']);

            $answer = $this->checkIfExistsAnswer($item['id']);

            $data = array_merge($arr, Arr::except($item, ['file', 'id']));

            $answer->update($data);

            if (Arr::exists($item, 'file')) {
                $answer->file = HelperRepo::upload_image($item['file'],"answers/$answer->id",[1600 => null]);
                $answer->save();
            }
        });

        $answers = Answer::where('question_id', $question_id)->orderBy('order', 'asc')->get();

        return AnswerResource::collection($answers);
    }

    public function deleteAnswer(int $question_id, int $answer_id): JsonResource
    {
        $this->checkIfExistsQuestion($question_id, $answer_id);

        $answer = $this->checkIfExistsAnswer($answer_id);

        $answer->delete();

        return JsonResource::make([
            'deleted' => true
        ]);
    }

    public function deleteAnswerByQuestionID(int $question_id): JsonResource
    {
        $question = $this->checkIfExistsQuestion($question_id, null);

        $question->answers->each(function ($answer) {
            $answer->delete();
        });

        return QuestionResource::make($question->refresh());
    }

    public function retrieveAllByQuestionID(int $question_id)
    {
        $this->checkIfExistsQuestion($question_id);

        $answers = Answer::where('question_id', $question_id)->orderBy('order', 'asc')->get();

        return AnswerResource::collection($answers);
    }

    public function changeAnswerOrderByQuestionID(ChangeAnswerOrderRequest $request, int $question_id)
    {
        $this->checkIfExistsQuestion($question_id);

        collect($request->ids)->each(function ($value, $answer_id) {
            $question = $this->checkIfExistsAnswer($answer_id);

            $question->update(['order' => $value]);
        });

        $answers = Answer::where('question_id', $question_id)->orderBy('order', 'asc')->get();

        return AnswerResource::collection($answers);
    }

    public function checkIfExistsAnswer(int $answer_id): Answer
    {
        return Answer::findOrFail($answer_id);
    }

    public function checkIfExistsQuestion(int $question_id, int $answer_id = null): Question
    {
        $question = Question::findOrFail($question_id);

        if ($answer_id) {
            if (!$question->answers->contains('id', $answer_id)) {
                return false;
            }
        }

        return $question;
    }
}
