<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;

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

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user = $this->userRepository->createUser($validated);

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
            $this->userRepository->logOut(Auth::guard('api')->user()->token());
            return Response(['message' => 'User logout successfully.'], 200);
        }
        return Response(['message' => 'Unauthorized'], 401);
    }

    // List all users
    public function index()
    {
        return response()->json($this->userRepository->getAllUsers());
    }

    // Show a current user
    public function showDetails()
    {
        if (Auth::guard('api')->check()) {
            return Response($this->userRepository->getUserDetails(), 200);
        }
        return Response(['message' => 'Unauthorized'], 401);
    }

    // Show a specific user
    public function show($id)
    {
        return response()->json($this->userRepository->getUserById($id));
    }

    // Create a new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user = $this->userRepository->createUser($validated);

        $user->syncRoles(['user']);
        return response()->json([
            'user' => $user,
            'message' => 'User Created Successfully'
        ], 201);
    }

    // Update a user
    public function update(Request $request, $id)
    {
        $user = $this->userRepository->getUserById($id);

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

        $user = $this->userRepository->updateUser($id, $validated);

        return response()->json([
            'message' => 'User Updated Successfully'
        ], 202);
    }

    // Delete a user
    public function destroy($id)
    {
        $user = $this->userRepository->getUserById($id);

        if (!$user) {
            return response()->json(['error' => 'User Not Found'], 404);
        }

        $this->userRepository->deleteUser($id);

        return response()->json(['message' => 'User Deleted Successfully']);
    }

    // Assign a role to a user
    public function assignRole(Request $request, $id)
    {
        $user = $this->userRepository->getUserById($id);

        if (!$user) {
            return response()->json(['error' => 'User Not Found'], 404);
        }

        $this->userRepository->assignRole($id, $request->roles);

        return response()->json([
            'message' => 'Role Assigned Successfully'
        ], 202);
    }

    // Get a user's permissions
    public function permissions($id)
    {
        $user = $this->userRepository->getUserById($id);

        if (!$user) {
            return response()->json(['error' => 'User Not Found'], 404);
        }

        return response()->json($this->userRepository->showPermissions($id));
    }
}
