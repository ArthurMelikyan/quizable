@extends('arthurmelikyan::layouts')
@section('quizable_content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-body pt-5 pb-5 vh-100">
            <div class="row">
                <h1 class="text-center flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ 'Welcome to '. config('quizable.appname') . ' dashboard'}}</h1>
            </div>
        </div>
    </div>
</div>
@endsection
