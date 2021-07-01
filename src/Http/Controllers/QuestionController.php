<?php

namespace Arthurmelikyan\Quizable\Http\Controllers;

use App\Http\Controllers\Controller;
use Arthurmelikyan\Quizable\Helpers\HelperRepo;
use Arthurmelikyan\Quizable\Http\Resources\QuestionResource;
use Arthurmelikyan\Quizable\Http\Requests\ChangeQuestionOrderRequest;
use Arthurmelikyan\Quizable\Http\Requests\CreateQuestionRequest;
use Arthurmelikyan\Quizable\Http\Requests\UpdateQuestionRequest;
use Arthurmelikyan\Quizable\Models\Question;
use Arthurmelikyan\Quizable\Models\Quiz;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Arthurmelikyan\Quizable\Models\Answer;
use Spatie\Url\Url;

use function Psy\debug;

class QuestionController extends Controller
{

    /**
     * @param CreateQuestionRequest $request
     * @param int $quiz_id
     * @return JsonResource
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function createQuestion(CreateQuestionRequest $request, int $quiz_id): JsonResource
    {
        $this->checkIfExistsQuiz($quiz_id);

        $data = $request->only([ 'title', 'type', 'file_type', 'url', ]) + ['quiz_id' => $quiz_id];

        if (isset($data['file_type']) && $data['file_type'] === 'youtube') {
            $data['url'] = $this->getYoutubeVideoID($data['url']);
        }

        $question = Question::create($data);

        if ($request->hasFile('file')) {
            // $path = ImageService::saveFile($request->file('file'), 'questions/' . $question->id);
            if (in_array($request->file->extension(), ['jpg','jpeg','png'])) {
                $question->file = HelperRepo::upload_image($request->file('file') ,"questions/$question->id",[1600 => null]);
            } else {
                $question->file = HelperRepo::upload_file($request->file('file'), "questions/$question->id");
            }
            $question->save();
        }

        return QuestionResource::make($question);
    }


    /**
     * @param UpdateQuestionRequest $request
     * @param int $quiz_id
     * @param int $question_id
     * @return JsonResource
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function updateQuestion(UpdateQuestionRequest $request, int $quiz_id, int $question_id): JsonResource
    {
        $this->checkIfExistsQuiz($quiz_id, $question_id);

        $question = $this->checkIfExistsQuestion($question_id);

        $data = $request->only([ 'title', 'type', 'file_type', 'url', ]) + ['quiz_id' => $quiz_id];

        if ($data['type'] === 'file' && isset($data['file_type']) && $data['file_type'] === 'youtube') {
            $data['url'] = $this->getYoutubeVideoID($data['url']);
        }

        if ($request->file('file')) {

            $data['url'] = null;
            // $path = ImageService::saveFile($request->file('file'), 'questions/' . $question->id);
            $data['file'] = HelperRepo::upload_image($request->file('file') ,"questions/$question->id",[1600 => null]);
        }
        $question->update($data);

        return QuestionResource::make($question);
    }


    /**
     * @param int $quiz_id
     * @return JsonResource
     */
    public function retrieveAllQuestionByQuizID(int $quiz_id): JsonResource
    {
        $questions = Question::where('quiz_id', $quiz_id)->orderBy('order', 'asc')->get();

        return QuestionResource::collection($questions);
    }


    /**
     * @param int $quiz_id
     * @param int $question_id
     * @return JsonResource
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function deleteQuestion(int $quiz_id, int $question_id): JsonResource
    {
        $this->checkIfExistsQuiz($quiz_id, $question_id);

        $question = $this->checkIfExistsQuestion($question_id);

        $question->delete();

        return JsonResource::make([
            'deleted' => true
        ]);
    }


    /**
     * @param ChangeQuestionOrderRequest $request
     * @param int $quiz_id
     * @return JsonResource
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function changeQuestionOrderByQuizID(ChangeQuestionOrderRequest $request, int $quiz_id): JsonResource
    {
        $this->checkIfExistsQuiz($quiz_id);

        collect($request->ids)->each(function ($value, $question_id) {
            $question = $this->checkIfExistsQuestion($question_id);

            $question->update(['order' => $value]);
        });

        $questions = Question::where('quiz_id', $quiz_id)->orderBy('order', 'asc')->get();

        return QuestionResource::collection($questions);
    }


    /**
     * @param int $quiz_id
     * @param int $question_id
     * @return JsonResource
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function retrieveOneByID(int $quiz_id, int $question_id): JsonResource
    {
        $this->checkIfExistsQuiz($quiz_id, $question_id);

        $question = $this->checkIfExistsQuestion($question_id);

        return QuestionResource::make($question);
    }


    /**
     * @param int $quiz_id
     * @param int $question_id
     * @return JsonResource
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function cloneQuestionWithAnswers(int $quiz_id, int $question_id): JsonResource
    {
        $this->checkIfExistsQuiz($quiz_id, $question_id);

        $question = $this->checkIfExistsQuestion($question_id);

        $question_data = Arr::except($question->toArray(), ['id', 'created_at', 'updated_at', 'deleted_at']);

        $question_data['title'] = 'Clone from ' . $question_data['title'];

        $cloned_question = Question::create($question_data);

        $cloned_question_id = $cloned_question->id;

        $question->answers->each(function ($answer) use($cloned_question_id) {

            $answer_data = Arr::except($answer->toArray(), ['id', 'question_id', 'created_at', 'updated_at', 'deleted_at']);

            Answer::create($answer_data + ['question_id' => $cloned_question_id]);
        });

        return QuestionResource::make($cloned_question->refresh());
    }


    /**
     * @param int $quiz_id
     * @param int|null $question_id
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function checkIfExistsQuiz(int $quiz_id, int $question_id = null): void
    {
        $quiz = Quiz::find($quiz_id);

        if (!$quiz || ($question_id && !$quiz->questions->contains('id', $question_id))) {
            throw new NotFoundHttpException();
        }

    }


    /**
     * @param int $question_id
     * @return Question
     * @throws NotFoundException
     */
    public function checkIfExistsQuestion(int $question_id): Question
    {
        $question = Question::find($question_id);

        if (!$question) {
            throw new NotFoundException();
        }

        return $question;
    }


    /**
     * @param string $url
     * @return string
     */
    public function getYoutubeVideoID(string $url): string
    {
        try {
            $url = Url::fromString($url);
            if (in_array($url->getHost(),['www.youtube.com','youtube.com']) && $url->getQueryParameter('v') && $url->getSegment(1) != 'embed') {
                return $url->getQueryParameter('v');
            } else if(in_array($url->getHost(),['www.youtu.be','youtu.be']) && $url->getSegment(1) != 'embed'){
                return $url->getSegment(1);
            } else if(in_array($url->getHost(),['www.youtube.com','youtube.com','www.youtu.be','youtu.be']) && $url->getSegment(1) == 'embed'){
                return $url->getSegment(2);
            }
        } catch (\Exception $e) {
            Log::error('error while parsing youtube url at getYoutubeVideoID ' .$e->getMessage());
        }
        return null;
    }
}
