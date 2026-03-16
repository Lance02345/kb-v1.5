<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\JourneyMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
   public function create_user() 
   {

   }
   Public function user_profile(User $user) {
    $user = User::where('id', Auth::id())->first();
    $savedSearches = $user->savedSearches()->latest('id')->get();
    return view('user.user_profile',compact('user','savedSearches'));

  
    }
   public function store_user() 
   {

   }
   public function update_user( User $user, Request $request) 
   {
    $this->validate($request, [
        'name' => 'required|max:255',
        'phone_number' => 'required|max:14',
        'avatar' => 'file|max:2048|mimes:jpeg,png,jpg,gif,svg,heic,heif',

    ]);
    if($request->hasFile('avatar')){
        $imagenamewithExt = $request->file('avatar')->getClientOriginalName();
        $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
        $extension = $request->file('avatar')->getClientOriginalExtension();
        $avatar_imgStore = $imagename.'_'.time().'.'.$extension;
        $path = $request->file('avatar')->storeAs('public/photos', $avatar_imgStore);
    }
        $changes = [];
        if ((string) $user->name !== (string) $request->name) {
            $changes['Name'] = $request->name;
        }
        if ((string) $user->phone_number !== (string) $request->phone_number) {
            $changes['Phone'] = $request->phone_number;
        }
        if($request->hasFile('avatar')) {
            $changes['Avatar'] = 'Updated';
        }

        $user->name = $request->name;
        $user->phone_number = $request->phone_number; 
     if($request->hasFile('avatar')) { $user->avatar = $avatar_imgStore;   } 
        

        $user->update();
        JourneyMailer::sendProfileUpdated($user, $changes);
        return redirect() -> route('user.user_profile',$user->id)->with('success','Updated Successfully');
   
      
      /*  if($request->hasFile('avatar')){
            $imagenamewithExt = $request->file('avatar')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $avatar_imgStore = $imagename.'_'.time().'.'.$extension;
            $path = $request->file('avatar')->storeAs('public/photos', $avatar_imgStore);
        } */ 
        
   } 

   public function update_password() 
   {

   }
   public function change_email() 
   {

   } 
   public function delete_account() 
   {

   }


} 
    
