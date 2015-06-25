<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Radio extends Model
{
    protected $guarded = [];
    protected $appends = array('typeahead_url');

    public static function search($query)
    {
        return Radio::where('name', 'LIKE', "%$query%");
    }

    public function getTypeaheadUrlAttribute()
    {
        return route('radios.show', $this->id);
    }
}
