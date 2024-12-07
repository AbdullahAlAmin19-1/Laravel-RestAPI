<?php

namespace App\Http\Controllers;

use Log;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view user', ['only' => ['index', 'show', 'permissions']]);
        $this->middleware('permission:create user', ['only' => ['store', 'assignRole']]);
        $this->middleware('permission:update user', ['only' => ['update']]);
        $this->middleware('permission:delete user', ['only' => ['destroy']]);
    }

    // Sign Up
    public function signUp(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->syncRoles(['user']);
        $token = $user->createToken('access_token')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'message' => 'User Created Successfully'
        ], 201);
    }

    //LogIn
    public function logIn(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        Auth::attempt($request->all());
        $checkUser = Auth::user();
        if ($checkUser) {
            $token = $checkUser->createToken('access_token')->accessToken;

            return response()->json([
                'token' => $token,
                'user' => $checkUser,
                'message' => 'Logged In Successfully'
            ], 202);
        } else {
            return response()->json(['error' => 'Credential does Not Match'], 404);
        }
    }

    //LogOut
    public function logOut()
    {

        if (Auth::guard('api')->check()) {
            $accessToken = Auth::guard('api')->user()->token();

            \DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken->id)
                ->update(['revoked' => true]);
            $accessToken->revoke();

            return Response(['message' => 'User logout successfully.'], 200);
        }
        return Response(['message' => 'Unauthorized'], 401);
    }

    // List all users
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Show a current user
    public function showDetails()
    {
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            return Response($user, 200);
        }
        return Response(['message' => 'Unauthorized'], 401);
    }

    // Show a specific user
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User Not Found'], 404);
        }

        return response()->json($user);
    }

    // Create a new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->syncRoles(['user']);
        return response()->json([
            'user' => $user,
            'message' => 'User Created Successfully'
        ], 201);
    }

    // Update a user
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User Not Found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:8|confirmed',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }
        $user->update($validated);

        return response()->json([
            'user' => $user,
            'message' => 'User Updated Successfully'
        ], 202);
    }

    // Delete a user
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User Not Found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User Deleted Successfully']);
    }

    // Assign a role to a user
    public function assignRole(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User Not Found'], 404);
        }

        // foreach ($request->roles as $roleName) {
        //     $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'api']);
        // }
        $user->syncRoles($request->roles);

        return response()->json([
            'message' => 'Role Assigned Successfully'
        ], 202);
    }

    // Get a user's permissions
    public function permissions($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User Not Found'], 404);
        }

        $permissions = $user->getAllPermissions();

        return response()->json($permissions);
    }
}
