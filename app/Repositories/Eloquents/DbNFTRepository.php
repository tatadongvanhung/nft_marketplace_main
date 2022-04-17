<?php

namespace App\Repositories\Eloquents;

use App\Models\NFT;
use App\Repositories\Interfaces\NFTRepository;

class DbNFTRepository extends DbRepository implements NFTRepository
{
    /**
     *  @param NFT $model
     *
     */
    function __construct(NFT $model)
    {
        $this->model = $model;
    } 

    public function getNFTByCID($cid)
    {
        return $this->model->where('cid', $cid)->first();
    }

    public function getListNFTbyAlbumId($albumId)
    {
        // return $this->model
        // ->select('nft.*')
        // ->join('albums', function($join) use ($albumId) {
        //     $join->on('albums.id', '=', 'nfts.album_id')
        //         ->where('albums.id', $albumId)
        //         ->whereNull('albums.deleted_at');
        // })->get();
        return $this->model->where('album_id', $albumId)->get();
    }

    public function getListNFTbyGenreId($genreId)
    {
        return $this->model->where('genre_id', $genreId)->get();
    }
}
