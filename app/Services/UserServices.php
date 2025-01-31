<?php

namespace App\Services;

use App\Exceptions\InvalidTransactionException;
use App\Models\User;
use App\Repositories\UserRepository;

class UserServices
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register($payload)
    {
        $this->userRepository->create($payload);
    }

    public function findAll()
    {
        return $this->userRepository->findAll();
    }

    public function validateTransaction(User $sender, float $amount)
    {
        if ($sender['user_type'] != User::COMMON) {
            throw new InvalidTransactionException('Usuário do Tipo Lojista não pode realizar transação');
        }

        if ($sender['balance'] < $amount) {
            throw new InvalidTransactionException('Saldo insuficiente',400);
        }

        return true;
    }

    public function findUserById($id)
    {
        return $this->userRepository->findUserById($id);
    }

    public function save($user)
    {
        return $this->userRepository->save($user);
    }
}
