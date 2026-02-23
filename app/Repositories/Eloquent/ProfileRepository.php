<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function getProfile(User $user): User
    {
        return $user;
    }

    public function updateProfile(User $user, array $data): User
    {
        $user->fill([
            'name' => $data['name'] ?? $user->name,
            'email' => $data['email'] ?? $user->email,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return $user;
    }

    public function updatePassword(User $user, string $newPassword): User
    {
        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        return $user;
    }
}
