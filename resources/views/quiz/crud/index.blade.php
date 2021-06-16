@extends('arthurmelikyan::layouts')
@section('quizable_content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    Quizes
                </h3>
            </div>
            <div class="ml-auto">
                <a href="{{route('quizable.quiz.create')}}" class="btn btn-create">
                    <i class="fas fa-plus"></i>
                    Create new Quiz
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    <table class="table mobile-table" id="quizable_table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
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
                                <td>{{$quiz->time_limit}}</td>
                                <td>{{ $quiz->created_at->format('Y-m-d h:i:s') }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{route('quizable.quiz.edit',$quiz->id)}}"
                                            class="ml-1 btn btn-sm btn-primary js-tooltip-enabled" data-toggle="tooltip"
                                            title="Edit" data-original-title="Edit">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{route('quizable.quiz.destroy', $quiz->id)}}" id="rm_{{$quiz->id}}" method="POST">
                                            @csrf
                                            @method("DELETE")
                                            <button type="button" class="ml-1 rm_w_confirm btn btn-sm btn-primary js-tooltip-enabled" data-text="Delete quiz?" data-form="#rm_{{$quiz->id}}" data-toggle="tooltip" title="Delete" data-original-title="Delete">
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
    </div>
</div>
@endsection
