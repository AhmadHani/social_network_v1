@extends("layouts.app")

@section("content")

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="text-center">
                        Edit your profile , {{Auth::user()->name}}
                        </div>
                    </div>
                    <div class="panel-body">
                        <form action="{{route("profile.update")}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}


                            <div class="form-group">
                                <label for="location">Name</label>
                                <input type="text" value="{{Auth::user()->name}}" name="name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="avatar">Update avatar</label>
                                <input type="file" name="avatar" class="form-control" accept="/image">
                            </div>

                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" value="{{Auth::user()->profile->location}}" name="location" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="about">About me</label>
                                <textarea name="about" class="form-control" id="about" cols="30" rows="10" required>{{Auth::user()->profile->about}}</textarea>
                            </div>
                            <div class="form-group">
                                <div class="text-center">
                                    <button class="btn btn-primary btn-lg" type="submit">
                                        Save your information
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection