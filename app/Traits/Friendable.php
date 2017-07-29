<?php
namespace App\Traits;

use App\Friend;
use App\User;

trait Friendable{

    public function add_friend($user_requested){

            if($user_requested == $this->id){
                return 0;
            }
            if($this->is_friend_with($user_requested) === 1){
                return "already friends";
            }
        if ($this->has_pending_friend_request_to($user_requested) === 1) {
            return "already send a friend request";
        }
            if($this->has_pending_friend_request_from($user_requested)){
                return $this->accept_friend($user_requested);
            }

        $addfriend = Friend::create([
            'requester'=>$this->id,
            'user_requested'=>$user_requested
        ]);
if($addfriend){
    return 1;
}else{
    return 0;
}
    }
    public function accept_friend($requester){
        if ($this->has_pending_friend_request_from($requester) === 0) {
            return 0;
        }
        $acceptfriend  = Friend::where("status",0)->where("user_requested",$this->id)->where("requester",$requester)->first();
        $acceptfriend->update([
            'status'=>1
        ]);
        if($acceptfriend){
            return 1;
        }else{
            return 0;
        }
    }
    public function friends(){
        $friends1 = [];

        $sf1 = Friend::where("status",1)->where("requester",$this->id)->get();

        foreach($sf1 as $friends){
            array_push($friends1,User::find($friends->user_requested));
        }
        $friends2 = [];

        $sf2 = Friend::where("status",1)->where("user_requested",$this->id)->get();

        foreach($sf2 as $friends){
            array_push($friends2,User::find($friends->requester));
        }
        return array_merge($friends1,$friends2);
    }

    public function friends_ids(){
        return collect($this->friends())->pluck("id")->toArray();
    }
    public function is_friend_with($user_id){
        if(in_array($user_id,$this->friends_ids())){
            return 1;
        }else{
            return 0;
        }

    }
    public function pending_friend_requests(){
        $users = [];

        $sf1 = Friend::where("status",0)->where("user_requested",$this->id)->get();

        foreach($sf1 as $sf){
            array_push($users,User::find($sf->requester));
        }
        return $users;
    }

    public function pending_friend_requests_ids(){
        return collect($this->pending_friend_requests())->pluck("id")->toArray();
    }
    public function pending_friend_requests_sent(){
        $users = [];
        $sf1 = Friend::where("status",0)->where("requester",$this->id)->get();
        foreach($sf1 as $sf){
            array_push($users,User::find($sf->user_requested));
        }
        return $users;
    }
    public function pending_friend_requests_sent_ids(){
        return collect($this->pending_friend_requests_sent())->pluck("id")->toArray();
    }
    public function has_pending_friend_request_from($user_id){
        if(in_array($user_id,$this->pending_friend_requests_ids())){
            return 1;
        }else{
            return 0;
        }
    }

    public function has_pending_friend_request_to($user_id)
    {
        if (in_array($user_id, $this->pending_friend_requests_sent_ids())) {
            return 1;
        } else {
            return 0;
        }
    }

}


?>