<?php

namespace App\Interfaces;

interface UserRepositoryInterface{
    public function getAllUsers();
    public function getUserById($user_id);
    public function deleteUser($user_id);
    public function createUser(array $userDetails);
    public function updateUser($user_id,array $newDetails);
    public function updateUserByEmail($email,array $newDetails);
}
