<?php

namespace App\Http\Controllers;
use App\Notifications\AcceptFriendRequest;
use App\User;
use App\Notifications\NewFriendRequest;
use Illuminate\Http\Request;
use Auth;
class FriendsController extends Controller
{
    public function check($id){
        if(Auth::user()->has_pending_friend_request_from($id)){
            return ['status'=>"pending"];
        }
        if(Auth::user()->has_pending_friend_request_to($id)){
            return ['status'=>"waiting"];
        }
        if(Auth::user()->is_friend_with($id)){
            return ['status'=>"friends"];
        }
        return ['status'=>0];
    }
    public function add_friend($id){
        $user = Auth::user()->add_friend($id);
        User::find($id)->notify(new NewFriendRequest(Auth::user()));
        return $user;
    }
    public function accept_friend($id){
        $user = Auth::user()->accept_friend($id);
        User::find($id)->notify(new AcceptFriendRequest(Auth::user()));
        return $user;
    }
}
