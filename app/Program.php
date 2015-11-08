<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    /**
     * Get the radio associated with the program.
     */
    public function radio()
    {
        return $this->belongsTo('App\Radio');
    }
}
