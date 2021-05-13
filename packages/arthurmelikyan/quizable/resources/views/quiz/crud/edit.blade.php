@extends('arthurmelikyan::layouts')
@push('css')
    <style>

    </style>
@endpush
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
                    Update Quiz
                </h3>
            </div>
            <div class="block block-rounded block-bordered">
                <ul class="nav nav-tabs nav-tabs-alt js-tabs-enabled p-3" data-toggle="tabs" role="tablist">
                   <h3 class="pl-3"> {{$quiz->title}}</h3>
                    <li class="nav-item ml-auto">
                        <a class="nav-link" data-toggle="tab" href="#edit-quiz">
                            <i class="fas fa-pen fa-2x"></i>
                        </a>
                    </li>
                </ul>
                <div class="block-content tab-content">
                    <div class="tab-pane" id="edit-quiz" role="tabpanel">
                        <form action="{{route('quizable.quiz.update',$quiz->id)}}" class="multiple_form" method="post">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                @include('arthurmelikyan::quiz.crud.forms', ['quiz'=>$quiz])
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="pb-3 -pt-3">
                <quiz></quiz>
            </div>
        </div>
    </div>
</main>
@endsection
