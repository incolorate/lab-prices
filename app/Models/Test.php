<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function synonyms()
    {
        return $this->hasMany(Synonym::class);
    }

    public function sources()
    {
        return $this->belongsToMany(Source::class, 'test_source_prices')->withPivot('price')->withTimestamps();
    }
}