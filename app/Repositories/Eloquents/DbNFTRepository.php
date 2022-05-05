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

    public function search($search)
    {
        return $this->model
        ->select(
            'nfts.*',
            'albums.name as album_name',
            'albums.description as album_description',
            'albums.album_picture',
        )
        ->join('albums', function($join){
            $join->on('albums.id', '=', 'nfts.album_id')
                ->whereNull('albums.deleted_at');
        })
        ->where('nfts.name', 'like', '%' . $search . '%')
        ->orWhere('albums.name', 'like', '%' . $search . '%')
        ->get();
    }

    public function searchNFT($search)
    {
        return $this->model
        ->where('name', 'like', '%' . $search . '%')
        ->get();
    }

    public function getNFTNotInAblum()
    {
        return $this->model
        ->where('album_id', 0)
        ->orWhereNull('album_id')
        ->get();
    }

    public function getByTokenIdAndAbumNull($tokenIds)
    {
        return $this->model
        ->whereIn('tokenId', $tokenIds)
        ->where(function($sub) {
            $sub->where('album_id', 0);
            $sub->orWhereNull('album_id');
        })
        ->get();
    }

    public function findNFTByTokenId($tokenId)
    {
        return $this->model->where('tokenId', $tokenId)->first();
    }
}
