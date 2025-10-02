<?php

namespace App\Console\Commands;

use App\Interfaces\Interfaces\Repositories\UserRepositoryInterface;
use Exception;
use Illuminate\Console\Command;

class CreateUserCommand extends Command
{
    protected $signature = 'user:create
                            {name : Nome do usuário}
                            {email : E-mail do usuário}
                            {password : Senha do usuário}';

    protected $description = 'Create a new admin user.';

    public function __construct(readonly private UserRepositoryInterface $userRepository)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $data = [
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => $this->argument('password')
        ];

        try {
            $this->userRepository->store($data);

            return Command::SUCCESS;

        } catch (Exception $e) {
            $this->error('Error to create user: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
