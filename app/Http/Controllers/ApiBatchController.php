<?php
/**
 * Created by Khatcher Holmes
 * Date: 9/27/15 6:04 PM
 */

namespace App\Http\Controllers;

use App\ApiBatch\ApiBatchRadiko;
use App\Radio;

/**
 * Controller class for running batches for updating programs
 * Class ApiBatchController
 * @package App
 */
class ApiBatchController extends Controller
{
    const RADIO_CATEGORY_IDS = array(
        1 => 'ApiBatchRadiko'
    );

    //TODO: add index(), update() methods + authorization
    public function index()
    {
        $api = new ApiBatchRadiko();
        $api->populateRadios();
    }

    public function update()
    {
        // get all radios sorted by API_CATEGORY_IDS
        // ex: `SELECT * FROM radios ORDER BY api_category_id DESC`
        $radios = Radio::all();
        $last_cid = 1;
        $last_class = "App\\ApiBatch\\".ApiBatchController::RADIO_CATEGORY_IDS[$last_cid];
        $c_API = new $last_class();
        foreach ($radios as $radio) {
            if ($radio['api_category_id'] != $last_cid) {
                if(!in_array($radio['api_category_id'], ApiBatchController::RADIO_CATEGORY_IDS)) {
                    \Log::error($radio['name'] . ' has unknown APIcategoryID: ' . $radio['api_category_id']);
                    continue;
                }
                $last_class = ApiBatchController::RADIO_CATEGORY_IDS[$radio['api_category_id']];
                $c_API = new $last_class();
                $last_cid = $radio['api_category_id'];
            }
            $c_API->getPrograms($radio['id']);
        }

    }

}