<?php

/**
 * This file contains the ApiGetJsonResultsTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Requests_Exception;
use Requests_Exception_HTTP_400;

/**
 * This class contains the tests for the Api.
 *
 * @covers Lunr\Spark\Facebook\Api
 */
class ApiGetJsonResultsTest extends ApiTest
{

    /**
     * Test that get_json_results() does a correct request.
     *
     * @param string ...$arguments Request parameters to expect.
     *
     * @dataProvider requestParamProvider
     * @covers       Lunr\Spark\Facebook\Api::get_json_results
     */
    public function testGetJsonResultsCallsRequest(...$arguments)
    {
        $count = count($arguments);

        $http_method_upper = 'GET';
        $params            = [];

        switch ($count)
        {
            case 3:
                $http_method_upper = strtoupper($arguments[2]);
            case 2:
                $params = $arguments[1];
            case 1:
            default:
                $url = $arguments[0];
        }

        $options['verify'] = TRUE;

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo($http_method_upper))
                   ->will($this->returnValue($this->response));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, $arguments);
    }

    /**
     * Test that get_json_results() throws an error if the request had an error.
     *
     * @covers Lunr\Spark\Facebook\Api::get_json_results
     */
    public function testGetJsonResultsThrowsErrorIfRequestHadError()
    {
        $output = [
            'error' => [
                'message' => 'Message',
                'code'    => 'Code',
                'type'    => 'Type',
            ],
        ];

        $url = 'http://localhost';

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo([]), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 400;
        $this->response->body        = json_encode($output);
        $this->response->url         = 'http://localhost/url/';

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->will($this->throwException(new Requests_Exception_HTTP_400('Not Found!')));

        $context = [ 'message' => 'Message', 'code' => 'Code', 'type' => 'Type', 'request' => 'http://localhost/url/' ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo('Facebook API Request ({request}) failed, {type} ({code}): {message}'), $this->equalTo($context));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost' ]);
    }

    /**
     * Test that get_json_results() throws an error if the request failed.
     *
     * @covers Lunr\Spark\Facebook\Api::get_json_results
     */
    public function testGetJsonResultsThrowsErrorIfRequestFailed()
    {
        $output = [
            'error' => [
                'message' => 'Message',
                'code'    => 'Code',
                'type'    => 'Type',
            ],
        ];

        $url = 'http://localhost';

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo([]), $this->equalTo('GET'))
                   ->will($this->throwException(new Requests_Exception('Network error!', 'curlerror', NULL)));

        $this->response->expects($this->never())
                       ->method('throw_for_status');

        $context = [ 'message' => 'Network error!', 'request' => 'http://localhost' ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo('Facebook API Request ({request}) failed: {message}'), $this->equalTo($context));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost' ]);
    }

    /**
     * Test that get_json_results() does not throw an error if the request was successful.
     *
     * @covers Lunr\Spark\Facebook\Api::get_json_results
     */
    public function testGetJsonResultsDoesNotThrowErrorIfRequestSuccessful()
    {
        $url = 'http://localhost';

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo([]), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = '{}';

        $this->response->expects($this->once())
                       ->method('throw_for_status');

        $this->logger->expects($this->never())
                     ->method('warning');

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost' ]);
    }

    /**
     * Test that get_json_results() returns an empty array if there was a request error.
     *
     * @covers Lunr\Spark\Facebook\Api::get_json_results
     */
    public function testGetJsonResultsReturnsEmptyArrayOnRequestError()
    {
        $output = [
            'error' => [
                'message' => 'Message',
                'code'    => 'Code',
                'type'    => 'Type',
            ],
        ];

        $url = 'http://localhost';

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo([]), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 400;
        $this->response->body        = json_encode($output);
        $this->response->url         = 'http://localhost/url/';

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->will($this->throwException(new Requests_Exception_HTTP_400('Not Found!')));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $this->assertArrayEmpty($method->invokeArgs($this->class, [ 'http://localhost' ]));
    }

    /**
     * Test that get_json_results() returns an empty array if there was a request failure.
     *
     * @covers Lunr\Spark\Facebook\Api::get_json_results
     */
    public function testGetJsonResultsReturnsEmptyArrayOnRequestFailure()
    {
        $output = [
            'error' => [
                'message' => 'Message',
                'code'    => 'Code',
                'type'    => 'Type',
            ],
        ];

        $url = 'http://localhost';

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo([]), $this->equalTo('GET'))
                   ->will($this->throwException(new Requests_Exception('Network error!', 'curlerror', NULL)));

        $this->response->expects($this->never())
                       ->method('throw_for_status');

        $method = $this->get_accessible_reflection_method('get_json_results');

        $this->assertArrayEmpty($method->invokeArgs($this->class, [ 'http://localhost' ]));
    }

    /**
     * Test that get_json_results() returns the request result on success.
     *
     * @covers Lunr\Spark\Facebook\Api::get_json_results
     */
    public function testGetJsonResultsReturnsResultsOnSuccessfulRequest()
    {
        $output = [
            'param1' => 1,
            'param2' => 2,
        ];

        $url = 'http://localhost';

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo([]), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = json_encode($output);

        $this->response->expects($this->once())
                       ->method('throw_for_status');

        $method = $this->get_accessible_reflection_method('get_json_results');

        $this->assertEquals([ 'param1' => 1, 'param2' => 2 ], $method->invokeArgs($this->class, [ 'http://localhost' ]));
    }

}

?>
