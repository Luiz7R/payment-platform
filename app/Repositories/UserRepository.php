<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{

    protected $modelClass = User::class;

    public function findUserByDocument(string $document)
    {

    }
}
