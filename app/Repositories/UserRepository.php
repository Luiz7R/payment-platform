<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{

    protected $modelClass = User::class;

    public function findUserById($id)
    {
        return $this->findById($id);
    }

    public function findUserByDocument(string $document)
    {
        return $this->findByAttribute('document', $document);
    }
}
