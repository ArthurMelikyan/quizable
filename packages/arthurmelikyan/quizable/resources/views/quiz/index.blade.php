@extends('arthurmelikyan::layouts')

@section('quizable_content')

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
    <div class="table-responsive"> 
        <table class="table table-bordered table-striped table-vcenter" id="quizable_table">
            <thead>
                <tr> 
                    <th>#</th>
                    <th>Title</th>
                    {{-- <th>Teacher</th> --}}
                    <th>Time</th>
                    <th>Created at</th> 
                    <th>actions</th>
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
                             <td>actions</td> 
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