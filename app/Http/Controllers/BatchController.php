<?php
/**
 * Created by Khatcher Holmes
 * Date: 7/26/15 5:01 PM
 */

namespace App\Http\Controllers;

use App\Radio;
use Illuminate\Http\Responses;
use App\Http\Controllers\Controller;

use Log;
use Response;

class BatchController extends Controller
{

    private $radios_list = array(
        array(""),
        array()
    );

    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function updatePrograms()
    {
    }
}