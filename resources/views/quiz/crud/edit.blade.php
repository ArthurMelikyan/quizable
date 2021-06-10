




@extends('arthurmelikyan::layouts')
@section('quizable_content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    Update Quiz
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @include('arthurmelikyan::quiz.partials.errors')
                <div class="col-md-12 border pt-3 pb-3">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="pl-3 pt-3"> {{$quiz->title}}</h3>
                        </div>
                        <div class="col-md-2 text-right pt-3">
                            <a data-toggle="collapse" href="#editQuiz" role="button" aria-expanded="false" aria-controls="editQuiz">
                                <i class="fas fa-pen fa-2x"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="collapse col-md-12" id="editQuiz">
                    <form action="{{route('quizable.quiz.update',$quiz->id)}}" class="multiple_form" method="post">
                        @csrf
                        @method('PUT')
                        @include('arthurmelikyan::quiz.crud.forms', ['quiz'=>$quiz])
                    </form>
                </div>
                <div class="col-md-12 pb-3 mt-5">
                        <quiz v-bind:quiz="{{json_encode($quiz)}}"></quiz>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
