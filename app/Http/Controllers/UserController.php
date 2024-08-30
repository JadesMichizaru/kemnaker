<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'profile_picture' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if ($request->hasFile('profile_picture')) {
            // Optionally, delete the old profile picture
            if ($user->profile_picture) {
                $oldPicturePath = public_path('images/' . $user->profile_picture);
                if (file_exists($oldPicturePath)) {
                    unlink($oldPicturePath);
                }
            }

            $profilePictureName = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('images'), $profilePictureName);
            $user->profile_picture = $profilePictureName;
        }


        return response()->json(['message' => 'Profile updated successfully!', 'user' => $user], 200);
        $user->save();
    }
}
