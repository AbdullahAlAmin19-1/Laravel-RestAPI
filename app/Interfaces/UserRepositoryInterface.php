<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function getAllUsers();
    public function getUserDetails();
    public function getUserById($userId);
    public function deleteUser($userId);
    public function createUser(array $userDetails);
    public function updateUser($userId, array $newDetails);
    public function assignRole($userId, array $newDetails);
    public function showPermissions($userId);
    public function logOut($accessToken);
}
