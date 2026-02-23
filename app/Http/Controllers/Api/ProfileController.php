<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profile\UpdatePasswordRequest;
use App\Http\Requests\Api\Profile\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    protected $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    /**
     * Display the user's profile information.
     */
    public function show(Request $request): JsonResponse
    {
        $user = $this->profileRepository->getProfile($request->user());
        return $this->successResponse(new UserResource($user));
    }

    /**
     * Update the user's profile information.
     */
    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $user = $this->profileRepository->updateProfile($request->user(), $request->validated());
        return $this->successResponse(new UserResource($user), __('messages.profile_updated'));
    }

    /**
     * Update the user's password.
     */
    public function password(UpdatePasswordRequest $request): JsonResponse
    {
        $this->profileRepository->updatePassword($request->user(), $request->validated('password'));
        return $this->successResponse(null, __('messages.password_updated'));
    }
}
