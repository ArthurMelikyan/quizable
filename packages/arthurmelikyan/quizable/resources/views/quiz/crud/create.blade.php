@extends('arthurmelikyan::layouts')
@section('quizable_content')


<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    Create Quiz
                </h3>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    @include('arthurmelikyan::quiz.partials.errors')
                <form action="{{route('quizable.quiz.store')}}" class="multiple_form" method="post">
                    @csrf
                    <div class="col-md-12">
                        @include('arthurmelikyan::quiz.crud.forms')
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
