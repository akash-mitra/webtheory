<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['check.permission']);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->isAdmin())
        {
            $users = User::withTrashed()->latest()->get();
        }
        else
        {
            $users = User::latest()->get();
        }

        return response()->json($users);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'preferences' => ["broadcast","database","mail"],
            'public_id' => Str::random(30)
        ]);

        $user->save();

        return response()->json($user);
    }



    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // $user->load('providers');
        return response()->json($user);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user->fill(request(['name', 'email', 'role', 'about_me']))->save();

        return response()->json($user);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $user= User::withTrashed()->findOrFail($id);

        $request->validate([
            'forceDelete' => 'sometimes|boolean'
        ]);

        if ($request->has('forceDelete') && $request->forceDelete === true)
        {
            $user->forceDelete();

            //todo - should we change the ownership of user's resources?
        }
        else
        {
            $user->delete();
        }

        return response()->json([
            "status" => "success",
            "operation" => $request->has('forceDelete') ? 'Delete' : 'Deactivate',
            "user" => $user,
        ], 204);
    }



    public function changePassword(Request $request)
    {
        // return $request->only('email');

        $request->validate([
            'current_password' => ['required', 'min:8', 'max:255'],
            'new_password' => ['required', 'min:8', 'max:255', 'confirmed'],
        ]);

        $user = auth()->user();

        // make sure user current password is correct
        if(! Hash::check($request->current_password, $user->password))
        {
            return response([
                'status' => 'failure',
                'message' => 'Account password is incorrect.'
            ], 401);
        }

        $user->password = Hash::make($request->new_password);

        $user->save();

        return response([
            'status' => 'success',
            'message' => 'Account password changed.'
        ]);
    }


}
