<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function history()
    {
        return $this->belongsTo(History::class);
    }
    
    public function tests()
    {
        return $this->hasOne(Test::class, 'test_id', 'test_id');
    }
}
