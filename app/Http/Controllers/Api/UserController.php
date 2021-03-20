<?php

namespace App\Http\Controllers\Api;

use App\Traits\SearchQueryFilter;
use App\User;
use App\Category;
use App\Page;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use SearchQueryFilter;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['check.permission'])->except(['user']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        $usersQuery = User::query();

        return $this->queryUsers($usersQuery, $request);
    }

    /**
     * Get list of users who are banned (soft deleted).
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function banned(Request $request): LengthAwarePaginator
    {
        $usersQuery = User::query();

        $usersQuery->whereNotNull('deleted_at');

        return $this->queryUsers($usersQuery, $request);
    }

    /**
     * Get list of users with unverified email addresses.
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function unverified(Request $request): LengthAwarePaginator
    {
        $usersQuery = User::query();

        $usersQuery->whereNull('email_verified_at');

        return $this->queryUsers($usersQuery, $request);
    }

    /**
     *
     * Perform query to the User model with additional
     * conditions for LIKE matches with query string.
     * @param $queryBuilder
     * @param $request
     * @return LengthAwarePaginator
     */
    private function queryUsers($queryBuilder, $request): LengthAwarePaginator
    {
        $queryBuilder = $this->applyQueryFilter(
            $queryBuilder,
            ['name', 'email', 'role'],
            $request->input('query')
        );

        if ($request->user()->isAdmin()) {
            $queryBuilder->withTrashed();
        }

        return $queryBuilder->latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        User::invalidateCache();

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'preferences' => ['broadcast', 'database', 'mail'],
            'public_id' => Str::random(30),
        ]);

        $user->save();

        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {
        $user->fill($request->only(['name', 'email', 'role', 'about_me']))->save();

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy($id, Request $request): JsonResponse
    {
        $user = User::withTrashed()->findOrFail($id);

        $request->validate([
            'forceDelete' => 'sometimes|boolean',
        ]);

        if ($request->has('forceDelete') && $request->input('forceDelete') === true) {
            $user->forceDelete();

            //todo - should we change the ownership of user's resources?
        } else {
            $user->delete();
        }

        return response()->json(
            [
                'status' => 'success',
                'operation' => $request->has('forceDelete') && $request->input('forceDelete') === true ? 'Delete' : 'Deactivate',
                'user' => $user,
            ],
            204
        );
    }

    /**
     * Remove Ban from user.
     *
     * @param $id
     * @return JsonResponse
     */
    public function restore($id): JsonResponse
    {
        $user = User::withTrashed()->findOrFail($id);

        $user->restore();

        return response()->json(
            [
                'status' => 'success',
                'operation' => 'Unban',
                'user' => $user,
            ]
        );
    }

    /**
     * Change the password of Auth user.
     *
     * @param Request $request
     * @return Response
     */
    public function changePassword(Request $request): Response
    {
        $request->validate([
            'current_password' => ['required', 'min:8', 'max:255'],
            'new_password' => ['required', 'min:8', 'max:255', 'confirmed'],
        ]);

        $user = auth()->user();

        // make sure user current password is correct
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return response(
                [
                    'status' => 'failure',
                    'message' => 'Account password is incorrect.',
                ],
                401
            );
        }

        $user->password = Hash::make($request->input('new_password'));

        $user->save();

        return response([
            'status' => 'success',
            'message' => 'Account password changed.',
        ]);
    }

    /**
     * @param User $user
     * @return LengthAwarePaginator
     */
    public function pages(User $user): LengthAwarePaginator
    {
        return $user
            ->pages()
            ->where('status', 'Live')
            ->with(['media', 'category'])
            ->paginate(10);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function comments(User $user): JsonResponse
    {
        $categoryComments = Category::with('comments')
            ->whereHas('comments', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->paginate(10);

        $pageComments = Page::with('comments')
            ->whereHas('comments', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->paginate(10);

        return response()->json(['categories' => $categoryComments, 'pages' => $pageComments]);
    }
}
