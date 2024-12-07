<?php

namespace App\Repositories;

use Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserDetails()
    {
        return Auth::guard('api')->user();
    }

    public function getUserById($userId)
    {
        return User::findOrFail($userId);
    }

    public function deleteUser($userId)
    {
        User::destroy($userId);
    }

    public function createUser(array $userDetails)
    {
        return User::create($userDetails);
    }

    public function updateUser($userId, array $newDetails)
    {
        return User::whereId($userId)->update($newDetails);
    }

    public function assignRole($userId, array $newDetails)
    {
        return User::find($userId)->syncRoles($newDetails);
    }

    public function showPermissions($userId)
    {
        return User::find($userId)->getAllPermissions();
    }

    public function logOut($accessToken)
    {
        \DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update(['revoked' => true]);
        $accessToken->revoke();
    }
}
