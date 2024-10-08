<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Synonym extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'test_id'];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
