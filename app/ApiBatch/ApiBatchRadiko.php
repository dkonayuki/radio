<?php
/**
 * Created by Khatcher Holmes
 * Date: 9/27/15 7:03 PM
 */

namespace App\ApiBatch;

use \App\Program;
use \App\Radio;

/**
 * Retrieves data from Radio.jp API (ref: http://www.dcc-jpl.com/foltia/wiki/radikomemo)
 * Class ApiBatchRadiko
 * @package App
 */
class ApiBatchRadiko extends ApiBatchBase
{
    const API_CATEGORY_ID = 1;
    const BASE_URL = "http://radiko.jp/v2/"; // "http://localhost:45000/";

    function __construct()
    {
        parent::__construct('ApiBatchRadiko');
    }

    /**
     * Function that returns list of programs for given radio for today
     * @param int $radio_id Radio ID
     * @return mixed Request result
     */
    public function getPrograms($radio_id)
    {

        try {
            $radio = Radio::findOrFail($radio_id);
            $radio_api_key = $radio['api_key'];
        } catch (\Exception $ex) {
            echo "Can't find radio with ID: [$radio_id] " . ", Err: " . $ex->getMessage(); // TODO: remove echoes
            \Log::alert("Can't find radio with ID: [$radio_id] " . ", Err: " . $ex->getMessage());
            return;
        }

        $this->setUrl(ApiBatchRadiko::BASE_URL)
            ->setMethod(ApiBatchBase::METHOD_GET)
            ->setTarget('api/program/station/today')
            ->setParams(array('station_id' => $radio_api_key));

        $res = null;
        try {
            $res = $this->execute();
        } catch (\Exception $ex) {
            echo "Radiko API call failed for station: [$radio_api_key] " . ", Err: " . $ex->getMessage(); // TODO: remove echoes
            \Log::alert("Radiko API call failed for station: [$radio_api_key] " . ", Err: " . $ex->getMessage());
        }

        // parse XML result
        $radiko = simplexml_load_string($res);
        if ($radiko === false || !isset($radiko->stations->station->scd->progs)) {
            echo "Radiko API XML parse failed for radiko station : [$radio_api_key] "; // TODO: remove echoes
            \Log::alert("Radiko API XML parse failed for radiko station : [$radio_api_key] ");
        }

        //var_dump($radiko->stations->station->scd);
        foreach ($radiko->stations->station->scd->progs->prog as $program) {
            echo (string)$program->title;
            echo "\n";
            echo (string)$program->info;
            echo "\n";
            echo (string)$program['ft'];
            echo "\n";
            echo (string)$program['to'];
            echo "\n";

            $radio->programs()->save(new Program([
            'title' => (string) $program->title,
                'desc' => (string) $program->info,
                'media_url' => '',
                'start_time' => date('Y-m-d H:i:s', strtotime((string) $program['ft'])),
                'end_time'   => date('Y-m-d H:i:s', strtotime((string) $program['to'])),
            ]));
        }
    }

    /**
     * Gets list of stations for evey area in Japan [ONLY RUN ONCE, should NOT be a batch]
     * Note: There is possibility that stations might duplicate
     * @throws ApiBatchException
     */
    public function populateRadios()
    {
        foreach ($this->area_list as $key => $val) {
            $this->setUrl(ApiBatchRadiko::BASE_URL)
                ->setMethod(ApiBatchBase::METHOD_GET)
                ->setTarget('station/list/' . $key . '.xml');

            $res = null;
            try {
                $res = $this->execute();
            } catch (\Exception $ex) {
                echo "Radiko API call failed for area: [$key] " . $val . ", Err: " . $ex->getMessage(); // TODO: remove echoes
                \Log::alert("Radiko API call failed for area: [$key] " . $val . ", Err: " . $ex->getMessage());
            }

            // parse XML result
            $area = simplexml_load_string($res);
            if ($area === false) {
                echo "Radiko API XML parse failed for area: [$key] " . $val; // TODO: remove echoes
                \Log::alert("Radiko API XML parse failed for area: [$key] " . $val);
                continue;
            }
            foreach ($area->station as $sxe_station) {
                echo (string)$sxe_station->id;
                echo "\n";// API key
                echo (string)$sxe_station->name;
                echo "\n";
                echo (string)$sxe_station->ascii_name;
                echo "\n";
                echo (string)$sxe_station->href;
                echo "\n";
                echo (string)$sxe_station->logo_large;
                echo "\n";

                $local_logo = "/images/media/" . (string)$sxe_station->id . '_' . basename((string)$sxe_station->logo_large);
                copy((string)$sxe_station->logo_large, public_path() . $local_logo);

                Radio::create([
                    'name' => (string)$sxe_station->name,
                    'description' => (string)$sxe_station->ascii_name,
                    'stream_url' => $this->getRadikoSURL((string)$sxe_station->id),
                    'logo_url' => $local_logo,
                    'website' => (string)$sxe_station->href,
                    'api_key' => (string)$sxe_station->id,
                    'api_category_id' => ApiBatchRadiko::API_CATEGORY_ID
                ]);
            }
            usleep(500); // sleep for half millisecond
        }
    }

    /**
     * Radiko API doesn't provide stations list with stream URL.
     * We need to call API 2nd time to get it.
     * @param string  $radio_api_key API key
     * @return string curled URL
     * @throws ApiBatchException
     */
    public function getRadikoSURL($radio_api_key)
    {
        //http://radiko.jp/v2/station/stream/TBS.xml
        $this->setUrl(ApiBatchRadiko::BASE_URL)
            ->setMethod(ApiBatchBase::METHOD_GET)
            ->setTarget('station/stream/' . $radio_api_key . '.xml');

        $res = null;
        try {
            $res = $this->execute();
        } catch (\Exception $ex) {
            echo "Radiko API call[stream] failed for station: [$radio_api_key] " . ", Err: " . $ex->getMessage(); // TODO: remove echoes
            \Log::alert("Radiko API call[stream] failed for station: [$radio_api_key] " . ", Err: " . $ex->getMessage());
        }

        // parse XML result
        $resX = simplexml_load_string($res);
        return ((string) ($resX->item[0]));
    }


    /**
     * in Radiko program information is given separately for each region of Japan.
     * TODO: uncomment remaining regions (commented for faster testing)
     * @var array $area_list
     */
    private $area_list = array(
        'JP1' => 'HOKKAIDO JAPAN',
        'JP2' => 'AOMORI JAPAN',
        'JP3' => 'IWATE JAPAN'/*,
        'JP4' => 'MIYAGI JAPAN',
        'JP5' => 'AKITA JAPAN',
        'JP6' => 'YAMAGATA JAPAN',
        'JP7' => 'FUKUSHIMA JAPAN',
        'JP8' => 'IBARAKI JAPAN',
        'JP9' => 'TOCHIGI JAPAN',
        'JP10' => 'GUNMA JAPAN',
        'JP11' => 'SAITAMA JAPAN',
        'JP12' => 'CHIBA JAPAN',
        'JP13' => 'TOKYO JAPAN',
        'JP14' => 'KANAGAWA JAPAN',
        'JP15' => 'NIIGATA JAPAN',
        'JP16' => 'TOYAMA JAPAN',
        'JP17' => 'ISHIKAWA JAPAN',
        'JP18' => 'FUKUI JAPAN',
        'JP19' => 'YAMANASHI JAPAN',
        'JP20' => 'NAGANO JAPAN',
        'JP21' => 'GIFU JAPAN',
        'JP22' => 'SHIZUOKA JAPAN',
        'JP23' => 'AICHI JAPAN',
        'JP24' => 'MIE JAPAN',
        'JP25' => 'SHIGA JAPAN',
        'JP26' => 'KYOTO JAPAN',
        'JP27' => 'OSAKA JAPAN',
        'JP28' => 'HYOGO JAPAN',
        'JP29' => 'NARA JAPAN',
        'JP30' => 'WAKAYAMA JAPAN',
        'JP31' => 'TOTTORI JAPAN',
        'JP32' => 'SHIMANE JAPAN',
        'JP33' => 'OKAYAMA JAPAN',
        'JP34' => 'HIROSHIMA JAPAN',
        'JP35' => 'YAMAGUCHI JAPAN',
        'JP36' => 'TOKUSHIMA JAPAN',
        'JP37' => 'KAGAWA JAPAN',
        'JP38' => 'EHIME JAPAN',
        'JP39' => 'KOUCHI JAPAN',
        'JP40' => 'FUKUOKA JAPAN',
        'JP41' => 'SAGA JAPAN',
        'JP42' => 'NAGASAKI JAPAN',
        'JP43' => 'KUMAMOTO JAPAN',
        'JP44' => 'OHITA JAPAN',
        'JP45' => 'MIYAZAKI JAPAN',
        'JP46' => 'KAGOSHIMA JAPAN',
        'JP47' => 'OKINAWA JAPAN'*/
    );
    
}