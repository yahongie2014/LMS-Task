<?php

namespace App\Repositories\Interfaces;

interface AuthRepositoryInterface
{
    public function register(array $data);

    public function findByPhone(string $phone, string $type);

    public function findByEmail(string $email, string $type);
}
