<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateRequest;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\JsonResponse;

class UserUpdateController extends Controller
{
    public function __construct(private readonly UserServiceInterface $service)
    {
    }

    public function handle(UserUpdateRequest $request, int $id): JsonResponse
    {
        $user = $this->service->updateUser($id, $request->validated());
        if ($user === null) {
            return response()->json([
                'message' => 'Usuário não encontrado.',
            ], 404);
        }

        return response()->json([
            'data' => $user,
        ]);
    }
}
