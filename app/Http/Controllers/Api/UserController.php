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
    public function index(Request $request)
    {
        $users = User::query();

        /**
         * This builds a "like" query based on the query string.
         * It breaks the query string in individual words and
         * tries to match any of those words in image name.
         */
        $query = $request->input('query');

        if (! empty($query))
        {
            $queryArray = explode(" ", $query);
            // a false where statement so that "or" condition below works
            $users->where('id', 0);

            foreach($queryArray as $q) {
                if (! empty($q)) {
                    $users->orWhere('name', 'like', '%' . $q . '%');
                    $users->orWhere('email', 'like', '%' . $q . '%');
                    $users->orWhere('role', 'like', '%' . $q . '%');
                }
            }
        }

        if (auth()->user()->isAdmin())
        {
            return $users->withTrashed()->latest()->paginate(100);
        }
        else
        {
            return $users->latest()->paginate(100);
        }
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



    /**
     * Change the password of Auth user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
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
