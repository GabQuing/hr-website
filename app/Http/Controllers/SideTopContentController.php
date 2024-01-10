<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SideTopContentController extends Controller
{
    //

    // public function profile_image(Request $request){

    //     $valid_extensions = ['jpg'];

    //     if(!$request->hasFile('photo')){
    //         return response()->json(['error'=>'Please select an image.']);
    //     }

    //     $extension = strtolower($request->file('photo')->getClientOriginalExtension());

    //     if(!in_array($extension, $valid_extensions)){
    //         return response()->json(['error'=>'Invalid file type. Please upload a JPG image.']);
    //     }

    //     $imageName = auth()->user()->id.'.jpg';
    //     $request->photo->move(public_path('profile_picture/img'), $imageName);

    //     $user = User::find(auth()->user()->id);
    //     $user->img = $imageName;
    //     $user->save();

    //     return response()->json(['success'=>'Image uploaded successfully.', 'photo_name'=>$user->img]);
    // }

    public function profile_image(Request $request){

        $request->validate([
            'photo' => 'required|mimes:jpeg'
        ]);
        
        $imageName = auth()->user()->id.'.'.$request->photo->extension();
        $request->photo->move(public_path('profile_picture/img'), $imageName);

        $user = User::find(auth()->user()->id);
        $user->img = $imageName;
        $user->save();

        return response()->json(['success'=>'Image uploaded successfully.', 'photo_name'=>$user->img]);
    }

}
