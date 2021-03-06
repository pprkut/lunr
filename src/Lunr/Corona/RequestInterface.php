<?php

/**
 * Request Abstraction Interface.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona;

/**
 * Interface for abstract access to request data.
 */
interface RequestInterface
{

    /**
     * Get access to certain request attributes.
     *
     *  'protocol'   The protocol used for the request
     *  'domain'     The domain used for the request
     *  'port'       The port used for the request
     *  'base_path'  The path on the server to the application
     *  'base_url'   All of the above combined
     *
     *  'sapi'       The PHP SAPI invoking the code
     *  'host'       The hostname of the server the script is running on
     *
     *  'controller' The controller requested
     *  'method'     The method requested of that controller
     *  'params'     The parameters for that method
     *  'call'       The call identifier, combining controller and method
     *
     * @param string $name Attribute name
     *
     * @return mixed $return Value of the chosen attribute
     */
    public function __get($name);

    /**
     * Retrieve a stored GET value.
     *
     * @param string|null $key Key for the value to retrieve
     *
     * @return mixed The value of the key, all GET values if no key is provided or NULL if not found.
     */
    public function get_get_data($key = NULL);

    /**
     * Retrieve a stored POST value.
     *
     * @param string|null $key Key for the value to retrieve
     *
     * @return mixed The value of the key, all POST values if no key is provided or NULL if not found.
     */
    public function get_post_data($key = NULL);

    /**
     * Retrieve a stored FILES value.
     *
     * @param mixed $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_files_data($key);

    /**
     * Retrieve a stored COOKIE value.
     *
     * @param mixed $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_cookie_data($key);

    /**
     * Retrieve a stored SERVER value.
     *
     * @param mixed $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_server_data($key);

    /**
     * Retrieve a stored HTTP Header from the SERVER value.
     *
     * @param mixed $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_http_header_data($key);

    /**
     * Negotiate & retrieve the client's prefered content type.
     *
     * @param array $supported Array containing the supported content types
     *
     * @return mixed $return The best match of the prefered content types or NULL
     *                       if there are no supported types or the header is not set
     */
    public function get_accept_format($supported = []);

    /**
     * Negotiate & retrieve the clients prefered language.
     *
     * @param array $supported Array containing the supported languages
     *
     * @return mixed $return The best match of the prefered languages or NULL if
     *                       there are no supported languages or the header is not set
     */
    public function get_accept_language($supported = []);

    /**
     * Negotiate & retrieve the clients prefered charset.
     *
     * @param array $supported Array containing the supported charsets
     *
     * @return mixed $return The best match of the prefered charsets or NULL if
     *                       there are no supported charsets or the header is not set
     */
    public function parse_accept_charset($supported = []);

}

?>
