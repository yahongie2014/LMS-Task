<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface ProfileRepositoryInterface
{
    /**
     * Get the authenticated user profile details.
     */
    public function getProfile(User $user): User;

    /**
     * Update the authenticated user profile information.
     */
    public function updateProfile(User $user, array $data): User;

    /**
     * Update the authenticated user password.
     */
    public function updatePassword(User $user, string $newPassword): User;
}
