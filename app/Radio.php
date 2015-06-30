<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Radio extends Model
{
    protected $guarded = [];
    protected $appends = ['typeahead_url', 'typeahead_img'];

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
        if ($this->image != '') {
            return asset('uploads/radios/' . $this->id . '/' . $this->image);
        }
        return asset('images/radio_logo.jpg');
    }
}
