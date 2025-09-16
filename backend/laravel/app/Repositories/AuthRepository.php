<?php
namespace App\Repositories;

use App\Models\User;

class AuthRepository
{
    public function register(array $data): User
    {
        return User::create($data);
    }
  
}