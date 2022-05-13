<?php

namespace App\Models;

use Error;
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

    /**
     * Get PrestaShop version of web app
     *
     * @return void
     */
    public static function getPrestaShopVersion($project_id)
    {
        $prestashopo_check_test_id = Test::where('name', 'PrestaShop check')->first()->id;

        $histories = History::where('project_id', $project_id)->latest()->get();

        foreach ($histories as $history) {
            try {
                $results = Result::where([
                    ['history_id', $history->id],
                    ['test_id', $prestashopo_check_test_id],
                    ['vulnerable', true],
                ])->first();

                if ($results) {
                    preg_match("/\d\.\d/", $results->info, $matches);
                    return $matches[0];
                }
            } catch (Error $e) {}
        }
        return false;
    }
}
