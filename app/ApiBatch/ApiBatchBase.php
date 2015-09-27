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
        // Try 3 times
        $try_count = 0;
        while (true) {
            $ch = curl_init();
            try {
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                if ($this->method === ApiBatchBase::METHOD_POST) {
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
                } else {
                    $request_url .= ('?' . $query);
                }
                curl_setopt($ch, CURLOPT_URL, $request_url);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                echo "Executing curl query (Try:" . $try_count . ") " . "[" . $this->method . "] " . $request_url . "\n"; // TODO: remove echoes
                \Log::info("Executing curl query (Try:" . $try_count . ") " . "[" . $this->method . "] " . $request_url);
                $response = curl_exec($ch);
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
}