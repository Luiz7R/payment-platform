<?php

namespace App\Services;

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

    public function userCanTransfer(User $sender)
    {
        if ($sender['user_type'] == User::MERCHANT) {
            return false;
        }

        return true;
    }

    public function hasBalance(User $sender, $amount)
    {
        return $sender['balance'] >= $amount;
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
