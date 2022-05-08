<?php

namespace App\Repositories\Eloquents;

use App\Models\Album;
use App\Repositories\Interfaces\AlbumRepository;
use Illuminate\Support\Facades\DB;

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

    public function searchAlbum($search)
    {
        return $this->model
        ->where('name', 'like', '%' . $search . '%')
        ->get();
    }

    public function getAlbumByMetamaskAddress($address)
    {
        return $this->model
        ->where('metamask_address', $address)
        ->get();
    }

    public function countAlbumInTime($from, $to)
    {
        if(!empty($from) && !empty($to)) {
            return $this->model
            ->where(DB::raw('DATE(created_at)'), '>=', $from)
            ->where(DB::raw('DATE(created_at)'), '<=', $to)
            ->withTrashed()->count();
        }
        return $this->model->withTrashed()->count();
    }
}
