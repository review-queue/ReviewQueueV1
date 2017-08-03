<?php

namespace ReviewQueueV1\Http;

/**
 * Class CurlClient
 * @package ReviewQueueV1\Http
 */
class CurlClient
{
    /**
     * @var resource Contains the curl resource created by `curl_init()` function
     */
    public $curl;

    /**
     * @var string
     */
    public $authKey;

    /**
     * @var array Response headers
     */
    public $headers;

    /**
     * @var string
     */
    public $responseCode;

    /**
     * @var array
     */
    public $info;

    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    /**
     * @var array
     */
    public static $errorCodes = ['400', '401', '403', '404', '405', '422', '429', '500', '503'];

    /**
     * CurlClient constructor.
     */
    public function __construct()
    {
        $this->curl = curl_init();
    }

    /**
     * @param $method
     * @param $endPoint
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function request($method, $endPoint, $data = [])
    {
        $query = '';

        if (count($data) > 0) {
            $query = http_build_query($data);
        }

        $url = $endPoint;

        $curlOptions = [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CAINFO         => __DIR__ . '/certs/cacert.pem',
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_USERPWD        => "Basic:" . $this->authKey,
            CURLINFO_HEADER_OUT    => true,
            CURLOPT_HEADERFUNCTION => [$this, "setHeaders"],
            CURLOPT_HTTPHEADER     => [
                'Accept: application/json'
            ],
        ];

        if ($method == self::METHOD_POST) {

            $curlOptions[CURLOPT_POST] = true;
            $curlOptions[CURLOPT_POSTFIELDS] = $query;

        } elseif ($method == self::METHOD_GET) {

            $url = $endPoint . '?' . $query;
            $curlOptions[CURLOPT_HTTPGET] = true;
            $curlOptions[CURLOPT_URL] = $url;
        }

        curl_setopt_array($this->curl, $curlOptions);

        $output = curl_exec($this->curl);

        $info = curl_getinfo($this->curl);

        $this->responseCode = $info['http_code'];

        $this->info = $info;

        if (in_array($this->responseCode, self::$errorCodes)) {
            $error = json_decode($output);
            $message = $error->status . ' - ' . $error->name . ' (' . $error->message . ')';
            throw new \Exception($message);
        }

        if ($output === false) {
            throw new \Exception(curl_error($this->curl));
        }

        curl_close($this->curl);

        return $output;
    }

    /**
     * @param $curl
     * @param $header_line
     * @return int
     */
    private function setHeaders($curl, $header_line)
    {
        $headers = explode("\r\n", $header_line);

        foreach ($headers as $i => $headerLine) {
            if ($headerLine === '') { //skip empty lines.
                continue;
            }

            $parts = explode(': ', $headerLine);

            if (isset($parts[1])) {
                $this->headers[$parts[0]] = $parts[1]; //use key name
            } else {
                $this->headers[$i] = $headerLine; //use index as key name
            }
        }

        return strlen($header_line);
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return mixed
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @param mixed $authKey
     */
    public function setAuthKey($authKey)
    {
        $this->authKey = $authKey;
    }
}