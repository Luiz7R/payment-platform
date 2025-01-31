<?php

namespace App\Repositories;

abstract class BaseRepository
{

    protected $modelClass;

    protected function newQuery()
    {
        return app($this->modelClass)->newQuery();
    }

    protected function model()
    {
        return app($this->modelClass);
    }

    protected function doQuery($query = null, $take = 15, $paginate = true)
    {
        if (is_null($query)) {
            $query = $this->newQuery();
        }

        if ($paginate == true) {
            return $query->paginate($take);
        }

        if ($take > 0 || $take !== false) {
            $query->take($take);
        }

        return $query->get();
    }

    public function getAll($take = 15, $paginate = true)
    {
        return $this->doQuery(null, $take, $paginate);
    }

    public function lists($column, $key = null)
    {
        return $this->newQuery()->lists($column, $key);
    }

    public function findById($id, $fail = true)
    {
        if ($fail) {
            return $this->newQuery()->findOrFail($id);
        }

        return $this->newQuery()->find($id);
    }

    public function findByAttribute(string $attribute, $value)
    {
        return $this->newQuery()->where($attribute, $value)->get();
    }

    public function create($payload)
    {
        dd($payload);
        return $this->modelClass->save($payload);
    }
}
