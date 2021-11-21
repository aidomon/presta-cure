<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function history()
    {
        return $this->hasMany(History::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function createUrlSlug($urlString)
    {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $urlString);
        return strtolower($slug);
    }
}
