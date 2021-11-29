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

    public static function extractProjectNameFromUrl($url)
    {
        $url = parse_url($url)["host"];
        $host_names = explode(".", $url);
        return ucfirst($host_names[count($host_names) - 2]);
    }
}
