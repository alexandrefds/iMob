<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\JsonResponse;

class UserDeleteController extends Controller
{
    public function __construct(private readonly UserServiceInterface $service)
    {
    }

    public function handle(int $id): JsonResponse
    {
        $deleted = $this->service->deleteUser($id);
        if (!$deleted) {
            return response()->json([
                'message' => 'Usuário não encontrado.',
            ], 404);
        }

        return response()->json([
            'data' => true,
        ]);
    }
}
