<?php
/**
 * Created by Khatcher Holmes
 * Date: 9/27/15 4:34 PM
 */

namespace App\ApiBatch;

/**
 * Class ApiBatchBase
 * @package App
 *
 * Base class for ApiBatch classes
 */
abstract class ApiBatchBase
{
    /**
     * ID used for api_category_id in radios database.
     * Needs to be defined for each subclass
     */
    const API_CATEGORY_ID = 0;
    const MAX_TRY = 3;

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    public $name;

    private $params = array();
    private $target = '';
    private $method = ApiBatchBase::METHOD_GET;
    private $url = '';

    /**
     * Class constructor
     *
     * @param string $name Name of the ApiBatch (for ex: 'radiko')
     */
    public function __construct($name = null)
    {
        $this->name = $name;
    }

    /**
     * Sets the base url for the API
     * @param string $url URL (should include port if any)
     * @return ApiBatchBase $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Sets url query parameters
     * Note: this will remove all old added parameters
     * @param  array $params Array of parameters
     * @return ApiBatchBase this class
     */
    public function setParams(array $params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Add parameter to query
     * @param string $name name
     * @param mixed $value value
     * @return ApiBatchBase this class
     */
    public function addParam($name, $value)
    {
        $this->params[$name] = $value;

        return $this;
    }

    /**
     * Set request method
     * @param string $method Request type ('POST', 'GET', 'PUT', 'DELETE')
     * @return ApiBatchBase this class
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Set request method
     * @param string $target
     * @return ApiBatchBase this class
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Function that executes request and returns result
     * @return mixed Request result
     * @throws \Exception
     */
    public function execute()
    {
        $response = null;
        // Prepare request URL
        if (empty($this->url)) {
            throw new ApiBatchException("Tried to execute curl request without base URL");
        }

        $query = (count($this->params) > 0) ? '' : http_build_query($this->params);
        $request_url = $this->url . $this->target;

        // Setup headers - I used the same headers from Firefox version 2.0.0.6
        // below was split up because php.net said the line was too long. :/
        $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
        $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Keep-Alive: 300";
        $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $header[] = "Accept-Language: en-us,en;q=0.5";
        $header[] = "Pragma: "; // browsers keep this blank.
        // Try 3 times
        $try_count = 0;

        while (true) {
            $ch = curl_init();

            try {
                // return result as data instead of outputting
                // and set random browser strings, and browser-like settings
                // so that it will be harder to detect

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERAGENT,      $this->ua_list[array_rand($this->ua_list)]);
                curl_setopt($ch, CURLOPT_HTTPHEADER,     $header);
                curl_setopt($ch, CURLOPT_TIMEOUT,        5);
                curl_setopt($ch, CURLOPT_ENCODING,       'gzip,deflate');

                if ($this->method === ApiBatchBase::METHOD_POST) {
                    curl_setopt($ch, CURLOPT_POST,       1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
                } else {
                    curl_setopt($ch, CURLOPT_HTTPGET, 1);
                    $request_url .= (empty($query) ? '' : ('?' . $query));
                }

                curl_setopt($ch, CURLOPT_URL, $request_url);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                echo "Executing curl query (Try:" . $try_count . ") " . "[" . $this->method . "] " . $request_url . "\n"; // TODO: remove echoes
                \Log::info("Executing curl query (Try:" . $try_count . ") " . "[" . $this->method . "] " . $request_url);

                $response = curl_exec($ch);
                curl_close($ch);
                if ($response == null) {
                    throw new ApiBatchException("No curl result");
                }
                break;

            } catch (\Exception $ex) {
                if ($try_count++ < ApiBatchBase::MAX_TRY) {
                    usleep(5000); // sleep for 5ms and retry
                    continue;
                } else {
                    $msg = "Failed to retrieve data";
                    if ($errno = curl_errno($ch)) {
                        $error_message = curl_strerror($errno);
                        $msg .= " (cURL error: [{$errno}]:\n {$error_message})";
                    }
                    throw new ApiBatchException($msg . " " . $ex->getMessage());
                }
            }
        }

        return $response;
    }

    /**
     * Function that returns list of radios
     * @return mixed
    abstract public function getRadios();
     */

    /**
     * Function that returns list of radios
     * @param int $radio_id Radio ID
     * @return mixed Request result
    abstract public function getRadio($radio_id);
     */

    /**
     * Function that returns list of programs for given radio for today
     * @param int $radio_id Radio ID
     * @return mixed Request result
     */
    abstract public function getPrograms($radio_id);

    /**
     * Function that returns detailed info for given radio program
     * @param int $radio_id Radio ID
     * @param int $program_id Program ID
     * @return mixed Request result
    abstract public function getProgram($radio_id, $program_id);
     */

    private $ua_list = array(
        "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.89 Safari/537.36", // Chrome 41 Windows 7
        "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36", // Chrome 45 Windows 7 x64
        "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0", // Firefox 40 Windows 7 x64
        "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:41.0) Gecko/20100101 Firefox/41.0", // Firefox 40 Ubuntu x64
        "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36", // Chrome 45 Windows 7
        "Mozilla/5.0 (Windows NT 6.1; rv:40.0) Gecko/20100101 Firefox/40.0", // Firefox 40 Windows 7
        "Mozilla/5.0 (X11; Ubuntu; Linux x86; rv:41.0) Gecko/20100101 Firefox/41.0", // Firefox 40 Ubuntu
        "Mozilla/5.0 (X11; Ubuntu; Linux x86; rv:40.0) Gecko/20100101 Firefox/40.0", // Firefox 40 Ubuntu
        "Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko", // IE 11.0 (32-bit) on Windows 8 (64 bit)
        "Mozilla/5.0 (Windows NT 6.1; Trident/7.0; rv:11.0) like Gecko", // IE 11.0 (32-bit) on Windows 8
        "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)", //  IE 10 on Windows 7 (64 bit)
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.78.2 (KHTML, like Gecko) Version/7.0.6 Safari/537.78.2", // Safari 7.0.6 running on Mac OS X 10.9.4
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/536.26.17 (KHTML, like Gecko) Version/6.0.2 Safari/536.26.17", // Safari 6.02 running on Mac OS X 10.8.2
    );
}