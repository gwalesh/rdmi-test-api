<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\http\Requests\StoreRegisterRequest;
use App\http\Requests\StoreImageUploadRequest;
use App\Http\Resources\RegisterResource;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function getUsers()
    {
        return $users = User::all();
    }

    public function register(Request $request)
    {
        $request->validate = ([
            'name' => ['string', 'max:251', 'nullable'],
            'email' => ['string', 'max:251', 'required', 'unique:users'],
            'password'  => ['string', 'min:8', 'required', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request['password']),
        ]);

        return response()->json([
            'status' => true,
            'message' => "Registartion Succesfull",
        ]);
    }

    public function uploadImage(Request  $request, $id)
    {
        $request->validate([
            ['name' => 'string' , 'required', 'max:250'],
            ['profile' => 'string' , 'nullable', 'max:250'],
        ]);


        // Handle File Upload
        if($request->hasFile('profile')){
            // Get filename with the extension
            $filenameWithExt = $request->file('profile')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('profile')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('profile')->storeAs('public/profiles', $fileNameToStore);
		
	    // make thumbnails
	    $thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
            $thumb = Image::make($request->file('profile')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage/profiles/'.$thumbStore);
		
        } else {
            $fileNameToStore = 'noimage.jpg';
        }


        $user = User::find($id);

        $user->update([
            'name' => $request->name,
            'profile' => $fileNameToStore,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Name and Image Uploaded Sucessfully",
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => "User Deleted Succesfully",
        ]);
    }

    public function showToken()
    {
        echo csrf_token();
    }
}
