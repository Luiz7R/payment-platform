<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{

    protected $modelClass = User::class;

    public function findUserById($id, $fail = true)
    {
        return $this->findById($id, $fail);
    }

    public function findUserByDocument(string $document)
    {
        return $this->findByAttribute('document', $document);
    }

    public function save($user)
    {
        return $user->save();
    }

    public function create($payload)
    {
        return $this->model()->create($payload);
    }

    public function findAll()
    {
        return $this->model()->all();
    }

    public function paginate($paginate = 15)
    {
        return $this->model()->paginate($paginate);
    }
}
