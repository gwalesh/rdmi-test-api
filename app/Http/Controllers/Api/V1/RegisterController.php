<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\http\Requests\StoreRegisterRequest;
use App\http\Requests\StoreImageRequest;
use App\Http\Resources\RegisterResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use Exception;

class RegisterController extends Controller
{
    use MediaUploadingTrait;

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

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request['password']),
            ]);

            return response()->json([
                'status' => true,
                'id' => $user->id,
                'message' => "Registartion Succesfull",
                'token' => $user->createToken('tokens')->plainTextToken
            ]);
        }
        catch(Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => $e,
                ]);
        }        
    }

    public function uploadImage(StoreImageRequest  $request, $id)
    {
        try {

            $user = User::find($id);

            $user->update($request->all());

            if ($request->input('profile', false)) {
                if (!$user->profile || $request->input('profile') !== $user->profile->file_name) {
                    if ($user->profile) {
                        $user->profile->delete();
                    }
                    $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile'))))->toMediaCollection('profile');
                }
            } elseif ($user->profile) {
                $user->profile->delete();
            }

            return response()->json([
                'status'    =>      true,
                'message'   =>      "Image Uploaded Succesfully",
            ]);
        }
        catch(Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e,
            ]);
        
        }
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

    public function selectCourse(Request $request, $id)
    {
        $request->validate([
            ['exam' => 'string' , 'nullable', 'max:250'],
            ['standard' => 'string' , 'nullable', 'max:250'],
            ['course' => 'string' , 'nullable', 'max:250'],
        ]);

        $user = User::find($id);

            try{
                $user->update([
                    'exam' => $request->name,
                    'standard' => $request->standard,
                    'course' => $request->course,
                ]);
            }
            catch(Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => $e,
                ]);
            }

        return response()->json([
            'status' => true,
            'message' => "Preferences Set Succesfully !",
        ]);
    }

    public function formView()
    {
        return view('user-image');
    }
    public function formsubmit(StoreImageRequest $request, $id)
    {

        try {
            // Handle File Upload

            $user = User::find($id);

            $user->update($request->all());

            if ($request->input('profile', false)) {
                if (!$user->profile || $request->input('profile') !== $user->profile->file_name) {
                    if ($user->profile) {
                        $user->profile->delete();
                    }
                    $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile'))))->toMediaCollection('profile');
                }
            } elseif ($user->profile) {
                $user->profile->delete();
            }

            return back()->with('success' , 'Image Uploaded Succesfully');
        }
        catch(Exception $e) {
            return back()->with('error', $e);
        
        }
    }
}
