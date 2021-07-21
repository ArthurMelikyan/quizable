<?php

namespace Arthurmelikyan\Quizable\Http\Controllers;

use App\Http\Requests\Quiz\CreateQuizRequest;
use App\Http\Requests\Quiz\UpdateQuizRequest;
use App\Http\Resources\QuizResource;
use Arthurmelikyan\Quizable\Http\Requests\QuizRequest;
use Arthurmelikyan\Quizable\Models\Quiz;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class QuizController extends BaseController {
    public function dashboard(){
        return view('arthurmelikyan::quiz.dashboard.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){
        $quizes = Quiz::orderByDesc('id')->paginate(20);
        return view('arthurmelikyan::quiz.crud.index',compact('quizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('arthurmelikyan::quiz.crud.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = [
//            'title.required' => 'Անվան դաշտը պարտադիր է լրացման համար',
//            'title.max' => 'Անվան դաշտը պարտադիր է լրացման համար',
            'title.required' => __('The title must be a string'),
        ];
        $validator = Validator::make($request->all(), [
            'title' => ['required','max:255'],
            'time_limit' => ['nullable', 'int','min:0','max:1440'],
            'description' => ['string','nullable','max:255'],
        ], $message);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        Quiz::create($request->all());
        return redirect()->route('quizable.quiz.index')->with('success','Quiz successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404); // TODO make this
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        return view('arthurmelikyan::quiz.crud.edit', compact('quiz'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Quiz $quiz)
    {
        $message = [
//            'title.required' => 'Անվան դաշտը պարտադիր է լրացման համար',
//            'title.max' => 'Անվան դաշտը պարտադիր է լրացման համար',
            'title.required' => __('The title must be a string'),
        ];
        $validator = Validator::make($request->all(), [
            'title' => ['required','max:255'],
            'time_limit' => ['nullable', 'int','min:0','max:1440'],
            'description' => ['string','nullable','max:255'],
        ], $message);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $quiz->update($request->all());
        return redirect()->route('quizable.quiz.index')->with('success','Quiz successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return back()->with('success','Quiz successfully removed');
    }

    // ! QUIZABLE

    public function retrieveAllQuizes(): JsonResource
    {
        $quizes = Quiz::orderBy('id', 'desc')->get();

        return QuizResource::collection($quizes);
    }

    public function retrieveOneByID(int $quiz_id): JsonResource
    {
        $quiz = $this->checkIfExistsQuiz($quiz_id);

        return QuizResource::make($quiz);
    }


    public function createQuiz(CreateQuizRequest $request): JsonResource
    {
        $data = $request->only([
            'title',
            'description',
            'time_limit',
            'answer_by_one',
        ]);
        $data['user_id'] = $request->user()->id;
        $data['is_active'] = false;

        $quiz = Quiz::create($data);

        return QuizResource::make($quiz->refresh());
    }

    public function quizIsActive(Request $request, $id)
    {
        $request->validate([
           'is_active' => 'boolean'
        ]);
        Quiz::find($id)->update($request->all());
        return response()->json('success', 200);

    }


    public function updateQuiz(UpdateQuizRequest $request, Quiz $quiz): JsonResource
    {
        $data = $request->only([
            'title',
            'description',
            'time_limit',
            'answer_by_one'
        ]);

        $quiz->update($data);

        return QuizResource::make($quiz->refresh());
    }

    public function deleteQuiz(int $quiz_id): JsonResource
    {
        $quiz = $this->checkIfExistsQuiz($quiz_id);

        $quiz->delete();

        return JsonResource::make([
            'deleted' => true,
        ]);
    }
}
