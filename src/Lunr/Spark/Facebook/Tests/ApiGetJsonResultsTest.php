<?php

/**
 * This file contains the ApiGetJsonResultsTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Lunr\Spark\Facebook\Api;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Api.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\Facebook\Api
 */
class ApiGetJsonResultsTest extends ApiTest
{

    /**
     * Test that get_josn_results() does a correct get_request without params.
     *
     * @param String $http_method HTTP method to use for the request.
     *
     * @dataProvider getMethodProvider
     * @covers       Lunr\Spark\Facebook\Api::get_json_results
     */
    public function testGetJsonResultsMakesGetRequestWithoutParams($http_method)
    {
        $this->curl->expects($this->once())
                   ->method('set_option')
                   ->with($this->equalTo('CURLOPT_FAILONERROR'), $this->equalTo(FALSE));

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo('http://localhost?'))
                   ->will($this->returnValue($this->response));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost', [], $http_method ]);
    }

    /**
     * Test that get_json_results() does a correct get_request with params.
     *
     * @param String $http_method HTTP method to use for the request.
     *
     * @dataProvider getMethodProvider
     * @covers       Lunr\Spark\Facebook\Api::get_json_results
     */
    public function testGetJsonResultsMakesGetRequestWithParams($http_method)
    {
        $this->curl->expects($this->once())
                   ->method('set_option')
                   ->with($this->equalTo('CURLOPT_FAILONERROR'), $this->equalTo(FALSE));

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo('http://localhost?param1=1&param2=2'))
                   ->will($this->returnValue($this->response));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost', [ 'param1' => 1, 'param2' => 2 ], $http_method ]);
    }

    /**
     * Test that get_json_results() does a correct post_request without params.
     *
     * @covers Lunr\Spark\Facebook\Api::get_json_results
     */
    public function testGetJsonResultsMakesPostRequestWithoutParams()
    {
        $this->curl->expects($this->once())
                   ->method('set_option')
                   ->with($this->equalTo('CURLOPT_FAILONERROR'), $this->equalTo(FALSE));

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with($this->equalTo('http://localhost'), $this->equalTo([]))
                   ->will($this->returnValue($this->response));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost', [], 'POST' ]);
    }

    /**
     * Test that get_json_results() does a correct post_request with params.
     *
     * @covers Lunr\Spark\Facebook\Api::get_json_results
     */
    public function testGetJsonResultsMakesPostRequestWithParams()
    {
        $this->curl->expects($this->once())
                   ->method('set_option')
                   ->with($this->equalTo('CURLOPT_FAILONERROR'), $this->equalTo(FALSE));

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with($this->equalTo('http://localhost'), $this->equalTo([ 'param1' => 1, 'param2' => 2 ]))
                   ->will($this->returnValue($this->response));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost', [ 'param1' => 1, 'param2' => 2 ], 'POST' ]);
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
                'code' => 'Code',
                'type' => 'Type',
            ]
        ];

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo('http://localhost?'))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(400));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue(json_encode($output)));

        $context = [ 'message' => 'Message', 'code' => 'Code', 'type' => 'Type', 'request' => 'http://localhost' ];

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with($this->equalTo('Facebook API Request ({request}) failed, {type} ({code}): {message}'), $this->equalTo($context));

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
        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo('http://localhost?'))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(200));

        $this->logger->expects($this->never())
                     ->method('error');

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
        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo('http://localhost?'))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(400));

        $this->response->expects($this->once())
                       ->method('get_result');

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
            'param2' => 2
        ];

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo('http://localhost?'))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(200));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue(json_encode($output)));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $this->assertEquals([ 'param1' => 1, 'param2' => 2 ], $method->invokeArgs($this->class, [ 'http://localhost' ]));
    }

}

?>
