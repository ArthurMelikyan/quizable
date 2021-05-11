@extends('arthurmelikyan::layouts')
@section('quizable_content')
<main id="main-container">
    <div class="bg-body-light">
        <div class="content content-full">
            @include('arthurmelikyan::quiz.partials.errors')
        </div>
    </div>
    <div class="content">
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Create Quiz
                </h3>
            </div>
            <form action="{{route('quizable.quiz.update',$quiz->id)}}" class="multiple_form" method="post">
                @csrf
                @method('PUT')
                <div class="col-md-12">
                    @include('arthurmelikyan::quiz.crud.forms', ['quiz'=>$quiz])
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
