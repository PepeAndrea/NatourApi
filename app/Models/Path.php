<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Path extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        //'difficulty_id',
        'difficulty',
        'disability',
        'length',
        'duration',
        'isReported',
        'user_id'
    ];

    protected $appends = ['username'];

    protected $hidden = ['user_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coordinates()
    {
        return $this->hasMany(Coordinate::class); 
    }

    public function interestPoints()
    {
        return $this->hasMany(InterestPoint::class); 
    }

    //Accessors
    
    public function getUsernameAttribute()
    {
        return $this->attributes['username'] = User::find($this->attributes["user_id"])->name;
    }

    /*

    public function getDifficultyIdAttribute($value)
    {
        return Difficulty::find($value)->symbol;
    }

    */
}
