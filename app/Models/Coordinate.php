<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinate extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'latitude',
        'longitude',
        'path_id',
    ];

    protected $hidden = [
        'path_id'
    ];

    public function path()
    {
        return $this->belongsTo(Path::class);
    }

}
