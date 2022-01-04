<?php

namespace App\Repositories;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct()
    {
        // Load the model
        $this->model = app()->make($this->getModel());
    }

    abstract public function getModel();
}