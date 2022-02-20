<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterestPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        //'category_id',
        'category',
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

    //Accessors

    /*
    public function getCategoryIdAttribute($value)
    {
        return Category::find($value)->name;
    }
    */

}
