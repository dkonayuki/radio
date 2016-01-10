<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Radio extends Model
{
    protected $guarded = [];
    protected $appends = ['typeahead_url', 'typeahead_img'];

    /**
     * Get the programs associated with the radio.
     */
    public function programs()
    {
        return $this->hasMany('App\Program');
    }

    /**
     * Get the categories associated with the radio.
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public static function search($query)
    {
        return Radio::where('name', 'LIKE', "%$query%");
    }

    public function getTypeaheadUrlAttribute()
    {
        return route('radios.show', $this->id);
    }

    public function getTypeaheadImgAttribute()
    {
        return $this->getImgUrl();
    }

    public function getImgUrl()
    {
        if ($this->logo_url != '') {
            return asset($this->logo_url);
        }
        return asset('images/radio_logo.jpg');
    }
}
