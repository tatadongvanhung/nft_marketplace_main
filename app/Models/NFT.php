<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NFT extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "nfts";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'cid',
        'album_id',
        'genre_id',
        'tokenId'
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];
}
