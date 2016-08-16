<?php

namespace RipeStat;

use Zend\Http\Client as HttpClient;
use Zend\Json\Json;

/**
 * Class AbuseContactFinder
 * Wrapper around the abuse-contact-finder from the Ripe Stat api
 *
 * https://stat.ripe.net/docs/data_api#AbuseContactFinder
 *
 * @package RipeStat
 */

class AbuseContactFinder
{
    /**
     * @var string
     */
    private $_url = 'http://stat.ripe.net/data/abuse-contact-finder/data.json';

    /**
     * @var null|HttpClient
     */
    private $_httpclient = null;

    /**
     * @var null|string
     */
    private $_appid = null;

    /**
     * AbuseContactFinder constructor.
     * @param string $appid
     */
    public function __construct($appid = null)
    {

        // set the appid in the class
        $this->_appid = $appid;

        // initialise the Zend Http Cient
        $this->_httpclient = new HttpClient();
    }

    /**
     * @param $searchterm
     * @return mixed|null
     * @throws \Exception
     */
    function get($searchterm)
    {
        $result = null;

        // construct query url
        $url = $this->_url . "?resource=$searchterm";

        if (!is_null($this->_appid)) {
            $url = $url . "&sourceapp=" . $this->_appid;
        }

        $this->_httpclient->setUri($url);
        $response = $this->_httpclient->send();

        if (!$response->isSuccess()) {
            throw (
            new \Exception(
                "Something went wrong, while talking to [$url], statuscode: {$response->getStatusCode()}"
            )
            );
        }

        // check if there aren't any errors
        $response = Json::decode($response->getBody(), Json::TYPE_OBJECT);
        if (strcmp($response->status, 'ok') == 0) {
            // no errors on the server side, return the data  of the object
            $result = $response->data;
        } else {
            throw new \Exception(
                "Error [" . $response->status_code . "]: [" . implode(',', $response->messages) . "]"
            );
        }

        return $result;
    }
}