<?php

namespace App\Interfaces;

interface PasswordResetRepositoryInterface{
    public function isValidToken($token);
    public function deleteTokenWithEmail($token,$email);
    public function createPasswordReset(array $details);
    public function getDetailsByToken($token);
}
