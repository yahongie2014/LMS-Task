<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Models\Instructor;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{
    public function register(array $data)
    {
        $type = $data['type'];
        unset($data['type']);
        
        $data['password'] = Hash::make($data['password']);
        
        $avatar = null;
        if (isset($data['avatar'])) {
            $avatar = $data['avatar'];
            unset($data['avatar']);
        }

        $model = ($type === 'instructor') 
            ? Instructor::create($data) 
            : User::create($data);

        if ($avatar) {
            $model->syncFile($avatar, 'avatars', 'avatar');
        }

        return $model;
    }

    public function findByPhone(string $phone, string $type)
    {
        return ($type === 'instructor') 
            ? Instructor::where('phone', $phone)->first() 
            : User::where('phone', $phone)->first();
    }

    public function findByEmail(string $email, string $type)
    {
        return ($type === 'instructor') 
            ? Instructor::where('email', $email)->first() 
            : User::where('email', $email)->first();
    }
}
