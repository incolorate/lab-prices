<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'website'];

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'test_source_prices')->withPivot('price')->withTimestamps();
    }
}