<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Models\User;

class UserProfileController extends Controller
{

    public function getUserProfile($id)
    {
        $userProfile = UserProfile::where('id_user', $id)->first();

        if (!$userProfile) {
            return response()->json(['message' => 'User profile not found'], 404);
        }

        return response()->json([
            'address' => $userProfile->address,
            'avatar' => $userProfile->avatar,
            'city' => $userProfile->city,
            'description' => $userProfile->description,
            'emailcontact' => $userProfile->emailcontact,
            'nickname' => $userProfile->nickname,
            'state' => $userProfile->state,
            'zipcode' => $userProfile->zipcode,
          

        ]);
    }



    public function store(Request $request)
    {
        $data = $request->all();
       
     
     
        $user = User::where('id_user', $data['data']['id_user'])->first();
      
       
      
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if (isset($data['data']['firstname'])) {
            $user->firstname = $data['data']['firstname'];
        }
        if (isset($data['data']['lastname'])) {
            $user->lastname = $data['data']['lastname'];
        }
        if (isset($data['data']['password'])) {
            $user->password = $data['data']['password'];
        }
        if (isset($data['data']['storename'])) {
            $user->storename = $data['data']['storename'];
        }
       
     
        $user->save();

       
        $userProfile = UserProfile::where('id_user', $data['data']['id_user'])->first();

        if (!$userProfile) {
            return response()->json(['message' => 'User profile not found'], 404);
        }

        if (isset($data['data']['imageUrl'])) {
            $userProfile->avatar = $data['data']['imageUrl'];
        }
        if (isset($data['data']['emailcontact'])) {
            $userProfile->emailcontact = $data['data']['emailcontact'];
        }
        
        if (isset($data['data']['nickname'])) {
            $userProfile->nickname = $data['data']['nickname'];
        }
        if (isset($data['data']['address'])) {
            $userProfile->address = $data['data']['address'];
        }
        if (isset($data['data']['city'])) {
            $userProfile->city = $data['data']['city'];
        }
        if (isset($data['data']['state'])) {
            $userProfile->state = $data['data']['state'];
        }
        if (isset($data['data']['zipcode'])) {
            $userProfile->zipcode = $data['data']['zipcode'];
        }
        if (isset($data['data']['description'])) {
            $userProfile->description = $data['data']['description'];
        }


        $userProfile->save();

      
        return response()->json(['message' => 'User profile updated successfully'], 200);

    }
}