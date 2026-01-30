<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\User\UserServiceInterface;
use Illuminate\Console\Command;

class CreateUserCommand extends Command
{
    protected $signature = 'user:create {--name=} {--email=} {--password=}';

    protected $description = 'Create a new user.';

    public function handle(UserServiceInterface $service): int
    {
        $name = (string) ($this->option('name') ?? '');
        $email = (string) ($this->option('email') ?? '');
        $password = (string) ($this->option('password') ?? '');

        if ($name === '') {
            $name = (string) $this->ask('Nome');
        }

        if ($email === '') {
            $email = (string) $this->ask('E-mail');
        }

        if ($password === '') {
            $password = (string) $this->secret('Senha');
        }

        if ($name === '' || $email === '' || $password === '') {
            $this->error('Nome, e-mail e senha são obrigatórios.');

            return self::FAILURE;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('E-mail inválido.');

            return self::FAILURE;
        }

        $user = $service->createUser([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $this->info('Usuário criado com sucesso.');
        $this->line('ID: '.$user->id);

        return self::SUCCESS;
    }
}
