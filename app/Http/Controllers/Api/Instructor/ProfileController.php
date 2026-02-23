<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return $this->successResponse(new UserResource($request->user()));
    }
}
