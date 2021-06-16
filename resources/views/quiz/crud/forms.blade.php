<div class="block block-rounded block-bordered">
    <div class="block-content">
        <div class="row justify-content-center py-sm-3 py-md-5">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Quiz title</label>
                            <input type="text" maxlength="255" value="{{$quiz->title ?? old('title')}}" class="form-control" id="title" name="title" placeholder="Enter quiz title..">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Duration</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-stopwatch"></i>
                                    </span>
                                </div>
                                <input type="number" value="{{$quiz->time_limit ?? old('time_limit')}}" min="0"  max="1440" class="form-control text-center" value="" id="time_limit" name="time_limit" placeholder="Enter duration...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" maxlength="255" placeholder="Description">{{$quiz->description ?? old('description')}}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="block-content block-content-full block-content-sm bg-body-light text-right">
        <a href="{{route('quizable.quiz.index')}}" class="btn btn-sm btn-light">
            <i class="fa fa-repeat"></i> Back
        </a>
        <button type="submit" class="btn btn-sm btn-success">
            <i class="fa fa-check"></i> Submit
        </button>
    </div>
</div>
