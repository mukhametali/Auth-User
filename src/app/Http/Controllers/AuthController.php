<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class AuthController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct(private readonly UserService $service)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        return response()->json($this->service->createUser(
            $request->name,
            $request->email,
            $request->password,
            $request->gender,
        ), Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->service->login(
            $request->email,
            $request->password
        );

        return $result['success'] ? response()->json($result, 200) : response()->json($result, 401);
    }

    public function profile(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }
}
