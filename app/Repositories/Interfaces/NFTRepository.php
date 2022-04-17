<?php

namespace App\Repositories\Interfaces;

interface NFTRepository
{
    public function getNFTByCID($cid);

    public function getListNFTbyAlbumId($albumId);

    public function getListNFTbyGenreId($genreId);

}
