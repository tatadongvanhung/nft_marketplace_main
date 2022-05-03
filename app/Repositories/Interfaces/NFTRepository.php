<?php

namespace App\Repositories\Interfaces;

interface NFTRepository
{
    public function getNFTByCID($cid);

    public function getListNFTbyAlbumId($albumId);

    public function getListNFTbyGenreId($genreId);

    public function search($search);

    public function searchNFT($search);

    public function getNFTNotInAblum();

    public function getByTokenIdAndAbumNull($tokenIds);
}
