<?php

namespace App\Repositories\Eloquents;

use App\Models\Album;
use App\Repositories\Interfaces\AlbumRepository;

class DbAlbumRepository extends DbRepository implements AlbumRepository
{
    /**
     *  @param Album $model
     *
     */
    function __construct(Album $model)
    {
        $this->model = $model;
    } 
}
