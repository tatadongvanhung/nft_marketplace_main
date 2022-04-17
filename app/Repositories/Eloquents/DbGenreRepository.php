<?php

namespace App\Repositories\Eloquents;

use App\Models\Genre;
use App\Repositories\Interfaces\GenreRepository;

class DbGenreRepository extends DbRepository implements GenreRepository
{
    /**
     *  @param Genre $model
     *
     */
    function __construct(Genre $model)
    {
        $this->model = $model;
    } 
}
