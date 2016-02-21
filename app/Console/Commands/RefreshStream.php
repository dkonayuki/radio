<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Radio;

class RefreshStream extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'radios:refreshurl {rId?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches and updates "Stream URL" of the radio station.';

    /**
     * Sleep interval between URL and stream URL json calls
     * @var integer
     */
    public static $SLEEP_ONE = 5000;

    /**
     * Sleep interval between each radio URL calls
     * @var integer
     */
    public static $SLEEP_TWO = 10000;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $radioId = $this->argument('rId');
        $this->info('Entered here, ' . $radioId);
        // update given singular radio
        if (!is_null($radioId))
        {
            $radio = Radio::find($radioId);
            if(is_null($radio))
            {
                $this->error('No radio with id="' . $radioId . '"');
                return false;
            }
            $this->refreshURL($radio);
        }
        else
        {
            $radios = Radio::all();
            if(is_null($radios))
            {
                $this->error('No radios found');
                return false;
            }
            foreach ($radios as $radio)
            {
                $this->refreshURL($radio);
                usleep($this::$SLEEP_TWO);
            }
        }
    }

    private function refreshURL(Radio $radio)
    {
        $url = $radio->website;
        //$url = "http://tunein.com/espnradio/";
        $this->info('Radio: "' . $radio->name . '",  Website: ' . $url);
        try
        {
            $raw = file_get_contents($url);
            $output = array();
            preg_match('/StreamUrl\":\"(.*?)\"/', $raw, $output);
            if(count($output) < 2 || empty($output[1]))
            {
                $this->error('Failed to get contents of URL "' . $url . '"');
                return false;
            }
            $this->info('Found json URL');
            usleep($this::$SLEEP_ONE);
            // if json URL begins with // add 'http:' in front of it
            $json_url = (starts_with($output[1], array('http', 'https')))
                ? $output[1] : ('http:' . $output[1]);

            $json = file_get_contents($json_url);
            // remove paranthesis and semicolon covering the json string
            $json = trim($json, "();");
            $json = trim($json, "();");
            $arr = json_decode($json, true);
            if(isset($arr["Streams"][0]["Url"]))
            {
                // remove 'source=tunein' from stream URL
                $streamUrl = str_replace("source=tunein", "", $arr["Streams"][0]["Url"]);
                $this->info('Got URL "' . $streamUrl . '", saving...');
                $radio->stream_url = $streamUrl;
                $radio->save();
                $this->info('Completed');
            }
            else
            {
                $this->error('No Stream URL found for "' . $radio->name . '"');
            }
        }
        catch (Exception $e)
        {
            $this->error('Exception occurred with message :' . $e->getMessage());
        }
    }
}
