<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['history_id'];

    public $timestamps = false;

    public function history()
    {
        return $this->belongsTo(History::class);
    }

    public function tests()
    {
        return $this->hasOne(Test::class, 'id', 'test_id');
    }
}
