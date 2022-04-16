<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ablum extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "ablums";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'description',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];
}
