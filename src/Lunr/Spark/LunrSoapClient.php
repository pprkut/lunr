<?php

/**
 * This file contains the LunrSoapClient class.
 *
 * @package    Lunr\Spark
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark;

use SoapClient;
use SoapHeader;

/**
 * Wrapper around SoapClient class.
 */
class LunrSoapClient extends SoapClient
{

    /**
     * Headers set for the next request.
     * @var array
     */
    protected $headers;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->headers = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->headers);
    }

    /**
     * Inits the client.
     *
     * @param string $wsdl    WSDL url
     * @param array  $options SOAP client options
     *
     * @return LunrSoapClient Self reference
     */
    public function init($wsdl, $options)
    {
        parent::__construct($wsdl, $options);
        return $this;
    }

    /**
     * Create a SoapHeader.
     *
     * @param string $namespace Header namespace
     * @param string $name      Header name
     * @param array  $data      Header data
     *
     * @return SoapHeader header created
     */
    public function create_header($namespace, $name, $data)
    {
        return new SoapHeader($namespace, $name, $data);
    }

    /**
     * Set the client headers.
     *
     * @param array|SoapHeader|null $headers Headers to set
     *
     * @return LunrSoapClient Self reference
     */
    public function set_headers($headers = NULL)
    {
        if ($this->__setSoapHeaders($headers) === TRUE)
        {
            if ($headers === NULL)
            {
                $this->headers = [];
            }
            elseif (!is_array($headers))
            {
                $this->headers = [ $headers ];
            }
            else
            {
                $this->headers = $headers;
            }
        }

        return $this;
    }

    /**
     * Get the client headers.
     *
     * @return array Array of SoapHeader classes for the next request
     */
    public function get_headers()
    {
        return $this->headers;
    }

    /**
     * Make
     */
    public function __soapCall($name, $args, $options = NULL, $inputHeaders = NULL, &$outputHeaders = NULL)
    {
        $this->headers = [];
        return parent::__soapCall($name, $args, $options, $inputHeaders, $outputHeaders);
    }

}

?>
