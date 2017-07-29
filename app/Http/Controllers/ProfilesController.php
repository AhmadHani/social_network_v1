<?php

namespace App\Http\Controllers;
use Auth;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class ProfilesController extends Controller
{
    public function index($slug){
        $user  = User::where("slug",$slug)->first();
        return view("profile.index")->withUser($user);
    }
    public function edit(){
        return view("profile.edit");
    }
    public function update(Request $request){
        $this->validate($request,[
            'location'=>"required",
            'about'=>"required|max:255"
        ]);
        if($request->hasFile("avatar")){
            Auth::user()->update([
                'avatar'=>$request->avatar->store("public/avatars")
            ]);
        }
        Auth::user()->profile()->update(['location'=>$request->location,'about'=>$request->about]);
        if($request->name) {
            Auth::user()->update(['name' => $request->name, 'slug' => str_slug($request->name)]);
        }
        Session::flash("success","profile updated");
        return redirect()->back();
        }
}
