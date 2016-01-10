<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = array('title', 'desc', 'media_url', 'start_time', 'end_time');
    /**
     * Get the radio associated with the program.
     */
    public function radio()
    {
        return $this->belongsTo('App\Radio');
    }
}
