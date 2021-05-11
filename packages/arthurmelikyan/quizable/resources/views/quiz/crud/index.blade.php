@extends('arthurmelikyan::layouts')
@section('quizable_content')
<main id="main-container">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Quizes</h1>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title">Quiz</h3>
                <div class="block-options">
                    <a href="{{route('quizable.quiz.create')}}" class="btn btn-success">
                        Create new quiz
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter" id="quizable_table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            {{-- <th>Teacher</th> --}}
                            <th>Time</th>
                            <th>Created at</th>
                            <th class="d-none d-md-table-cell text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($quizes as $quiz)
                        <tr>
                            <td>{{$quiz->id}}</td>
                            <td>{{$quiz->title}}</td>
                            {{-- <td>{{$quiz->instructior}}</td>
                            ?? check do we need instructors here?
                            --}}
                            <td>{{$quiz->time_limit}}</td>
                            <td>{{(!is_null($quiz->created_at)) ?? $quiz->created_at->format('Y-m-d h:i:s')}}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{route('quizable.quiz.edit',$quiz->id)}}"
                                        class="ml-1 btn btn-sm btn-primary js-tooltip-enabled" data-toggle="tooltip"
                                        title="Edit" data-original-title="Edit">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{route('quizable.quiz.destroy', $quiz->id)}}" id="rm_{{$quiz->id}}"
                                        method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <button type="button"
                                            class="ml-1 rm_w_confirm btn btn-sm btn-primary js-tooltip-enabled"
                                            data-text="Delete quiz?" data-form="#rm_{{$quiz->id}}" data-toggle="tooltip"
                                            title="Delete" data-original-title="Delete">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <h1>no quizes to show</h1>
                        @endforelse

                    </tbody>

                </table>
                <div class="col-md-12 mt-4">
                    {{$quizes->links()}}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
