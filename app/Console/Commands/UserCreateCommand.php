<?php

namespace App\Console\Commands;

use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserCreateCommand extends Command
{
    protected $signature = 'user:create
                            {--name=}
                            {--email=}
                            {--password=}';

    protected $description = 'Create an admin user.';

    public function handle(): void
    {
        $name = $this->option('name') ?? $this->ask('Digite o nome do usuário');
        $email = $this->option('email') ?? $this->ask('Digite o email do usuário');
        $password = $this->option('password') ?? $this->secret('Digite a senha do usuário');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
        }

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $this->info('Usuário criado com sucesso!');
            $this->line("ID: {$user->id}");
            $this->line("Nome: {$user->name}");
            $this->line("Email: {$user->email}");

        } catch (Exception $e) {
            $this->error('Erro ao criar usuário: ' . $e->getMessage());
        }
    }
}
