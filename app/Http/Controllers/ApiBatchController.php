<?php
/**
 * Created by Khatcher Holmes
 * Date: 9/27/15 6:04 PM
 */

namespace App\Http\Controllers;

use App\ApiBatch\ApiBatchRadiko;

/**
 * Controller class for running batches for updating programs
 * Class ApiBatchController
 * @package App
 */
class ApiBatchController extends Controller
{
    //TODO: add index(), update() methods + authorization
    public function index()
    {
        $api = new ApiBatchRadiko();
        $api->populateRadios();
    }

    public function update()
    {

    }

}