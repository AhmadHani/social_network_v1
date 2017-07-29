@extends("layouts.app")

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="text-center">
                            {{$user->name}}'s Profile
                        </div>
                    </div>
                    <div class="panel-body">
                        <center>
                            <img src="{{$user->avatar}}" alt="{{$user->name}}'s Avatar" with="100px" height="100px">
                        </center>
                        <br>
                        <p class="text-center">{{$user->profile->location}}</p>
                        <br>
                        <div class="text-center">
                            @if(Auth::id() == $user->id)
                                <a href="{{route("profile.edit")}}" class="btn btn-primary">Edit your profile</a>

                                @endif
                        </div>
                    </div>
                </div>
                @if(Auth::id() != $user->id)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <friend :id="{{$user->id}}"></friend>
                    </div>
                </div>
                    @endif
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="text-center">
                                About me
                            </div>
                        </div>
                        <div class="panel-body">

                            <p class="text-center">{{$user->profile->about}}</p>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    @endsection