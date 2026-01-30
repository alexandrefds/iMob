<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\JsonResponse;

class UserGetController extends Controller
{
    public function __construct(private readonly UserServiceInterface $service)
    {
    }

    public function handle(int $id): JsonResponse
    {
        $user = $this->service->getUserById($id);
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
