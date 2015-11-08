<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    /*
     * Get the radios associated with the given category.
     */
    public function radios() {
        return $this->belongsToMany('App\Radio');
    }
}
