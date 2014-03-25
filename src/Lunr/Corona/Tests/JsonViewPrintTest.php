<?php

/**
 * This file contains the JsonViewPrintTest class.
 *
 * PHP Version 5.4
 *
 * @category   Library
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains tests for the JsonView class.
 *
 * @category      Library
 * @package       Corona
 * @subpackage    Tests
 * @author        Heinz Wiesinger <heinz@m2mobi.com>
 * @covers        Lunr\Corona\JsonView
 * @backupGlobals enabled
 */
class JsonViewPrintTest extends JsonViewTest
{

    /**
     * JSON return value;
     * @var Array
     */
    private $json;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUp();

        $this->json = [ 'a' => 100, 'b' => [ 'z' => TRUE ], 'c' => [ NULL ], 'd' => new \stdClass() ];
    }

    /**
     * Test that print_page() prints JSON with the response code as error info.
     *
     * @param mixed $error_info Non-integer error info value
     *
     * @dataProvider invalidErrorInfoProvider
     * @requires     extension runkit
     * @covers       Lunr\Corona\JsonView::print_page
     */
    public function testPrintPagePrintsJsonWithCode($error_info)
    {
        $this->response->expects($this->once())
                       ->method('get_return_code_identifiers')
                       ->with($this->equalTo(TRUE))
                       ->will($this->returnValue('id'));

        $this->response->expects($this->once())
                       ->method('get_error_info')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(NULL));

        $this->response->expects($this->once())
                       ->method('get_error_message')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue('Message'));

        $this->response->expects($this->once())
                       ->method('get_return_code')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(404));

        $this->response->expects($this->once())
                       ->method('get_response_data')
                       ->will($this->returnValue($this->json));

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('sapi'))
                      ->will($this->returnValue('cli'));

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/json_code.json');

        $this->mock_function('header', '');

        $this->class->print_page();

        $this->unmock_function('header');
    }

    /**
     * Test that print_page() prints JSON with an empty string as message if message is missing.
     *
     * @requires extension runkit
     * @covers   Lunr\Corona\JsonView::print_page
     */
    public function testPrintPagePrintsJsonWithoutMessage()
    {
        $this->response->expects($this->once())
                       ->method('get_return_code_identifiers')
                       ->with($this->equalTo(TRUE))
                       ->will($this->returnValue('id'));

        $this->response->expects($this->once())
                       ->method('get_error_info')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(NULL));

        $this->response->expects($this->once())
                       ->method('get_error_message')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(NULL));

        $this->response->expects($this->once())
                       ->method('get_return_code')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(404));

        $this->response->expects($this->once())
                       ->method('get_response_data')
                       ->will($this->returnValue($this->json));

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('sapi'))
                      ->will($this->returnValue('cli'));

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/json_empty_message.json');

        $this->mock_function('header', '');

        $this->class->print_page();

        $this->unmock_function('header');
    }

    /**
     * Test that print_page() prints JSON.
     *
     * @requires extension runkit
     * @covers   Lunr\Corona\JsonView::print_page
     */
    public function testPrintPagePrintsJson()
    {
        $this->response->expects($this->once())
                       ->method('get_return_code_identifiers')
                       ->with($this->equalTo(TRUE))
                       ->will($this->returnValue('id'));

        $this->response->expects($this->once())
                       ->method('get_error_info')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(4040));

        $this->response->expects($this->once())
                       ->method('get_error_message')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue('Message'));

        $this->response->expects($this->once())
                       ->method('get_return_code')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(404));

        $this->response->expects($this->once())
                       ->method('get_response_data')
                       ->will($this->returnValue($this->json));

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('sapi'))
                      ->will($this->returnValue('cli'));

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/json_complete.json');

        $this->mock_function('header', '');

        $this->class->print_page();

        $this->unmock_function('header');
    }

    /**
     * Test that print_page() for a non-cli SAPI does not pretty print the output.
     *
     * @covers Lunr\Corona\JsonView::print_page
     */
    public function testPrintPageForWebDoesNotPrettyPrint()
    {
        $this->response->expects($this->once())
                       ->method('get_return_code_identifiers')
                       ->with($this->equalTo(TRUE))
                       ->will($this->returnValue('id'));

        $this->response->expects($this->once())
                       ->method('get_error_info')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(4040));

        $this->response->expects($this->once())
                       ->method('get_error_message')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue('Message'));

        $this->response->expects($this->once())
                       ->method('get_return_code')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(404));

        $this->response->expects($this->once())
                       ->method('get_response_data')
                       ->will($this->returnValue($this->json));

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('sapi'))
                      ->will($this->returnValue('web'));

        $this->expectOutputString('{"data":{"a":100,"b":{"z":true},"c":[null],"d":{}},"status":{"code":4040,"message":"Message"}}');

        $this->mock_function('header', '');

        $this->class->print_page();

        $this->unmock_function('header');
    }

    /**
     * Test that print_page() with empty data value.
     *
     * @covers Lunr\Corona\JsonView::print_page
     */
    public function testPrintPageWithEmptyData()
    {
        $this->response->expects($this->once())
                       ->method('get_return_code_identifiers')
                       ->with($this->equalTo(TRUE))
                       ->will($this->returnValue('id'));

        $this->response->expects($this->once())
                       ->method('get_error_info')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(4040));

        $this->response->expects($this->once())
                       ->method('get_error_message')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue('Message'));

        $this->response->expects($this->once())
                       ->method('get_return_code')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(404));

        $this->response->expects($this->once())
                       ->method('get_response_data')
                       ->will($this->returnValue([]));

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('sapi'))
                      ->will($this->returnValue('cli'));

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/json_empty_data.json');

        $this->mock_function('header', '');

        $this->class->print_page();

        $this->unmock_function('header');
    }

    /**
     * Test that print_page() returns data when If-None-Match header is specified and does not match.
     *
     * @covers Lunr\Corona\JsonView::print_page
     */
    public function testPrintPageWithIfNoneMatchHeaderSpecifiedAndNoMatchReturnsContent()
    {
        $_SERVER['HTTP_IF_NONE_MATCH'] = 'something';

        $this->response->expects($this->once())
                       ->method('get_return_code_identifiers')
                       ->with($this->equalTo(TRUE))
                       ->will($this->returnValue('id'));

        $this->response->expects($this->once())
                       ->method('get_error_info')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(4040));

        $this->response->expects($this->once())
                       ->method('get_error_message')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue('Message'));

        $this->response->expects($this->once())
                       ->method('get_return_code')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(404));

        $this->response->expects($this->once())
                       ->method('get_response_data')
                       ->will($this->returnValue($this->json));

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('sapi'))
                      ->will($this->returnValue('cli'));

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/json_complete.json');

        $this->mock_function('header', '');

        $this->class->print_page();

        $this->unmock_function('header');
    }

    /**
     * Test that print_page() returns no data when If-None-Match header is specified and matches.
     *
     * @covers Lunr\Corona\JsonView::print_page
     */
    public function testPrintPageWithIfNoneMatchHeaderSpecifiedAndMatchReturnsNoData()
    {
        $_SERVER['HTTP_IF_NONE_MATCH'] = 'c1210cc1a603c0012f3854d2372341e5b93f85a38357fd7449995278ce188852';

        $this->response->expects($this->once())
                       ->method('get_return_code_identifiers')
                       ->with($this->equalTo(TRUE))
                       ->will($this->returnValue('id'));

        $this->response->expects($this->once())
                       ->method('get_error_info')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(4040));

        $this->response->expects($this->once())
                       ->method('get_error_message')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue('Message'));

        $this->response->expects($this->once())
                       ->method('get_return_code')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(404));

        $this->response->expects($this->once())
                       ->method('get_response_data')
                       ->will($this->returnValue($this->json));

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('sapi'))
                      ->will($this->returnValue('cli'));

        $this->expectOutputString('');

        $this->mock_function('header', '');

        $this->class->print_page();

        $this->unmock_function('header');
    }

    /**
     * Test that print_page() sets the proper JSON content type.
     *
     * @runInSeparateProcess
     *
     * @requires extension xdebug
     * @covers   Lunr\Corona\JsonView::print_page
     */
    public function testPrintPageSetsContentType()
    {
        $this->response->expects($this->once())
                       ->method('get_return_code_identifiers')
                       ->with($this->equalTo(TRUE))
                       ->will($this->returnValue('id'));

        $this->response->expects($this->once())
                       ->method('get_error_info')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(4040));

        $this->response->expects($this->once())
                       ->method('get_error_message')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue('Message'));

        $this->response->expects($this->once())
                       ->method('get_return_code')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(404));

        $this->response->expects($this->once())
                       ->method('get_response_data')
                       ->will($this->returnValue($this->json));

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('sapi'))
                      ->will($this->returnValue('cli'));

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/json_complete.json');

        $this->class->print_page();

        $headers = xdebug_get_headers();

        $this->assertInternalType('array', $headers);
        $this->assertNotEmpty($headers);

        $this->assertEquals('Content-type: application/json', $headers[0]);
    }

    /**
     * Test that print_page() sets an ETag header.
     *
     * @runInSeparateProcess
     *
     * @requires extension xdebug
     * @covers   Lunr\Corona\JsonView::print_page
     */
    public function testPrintPageSetsETag()
    {
        $this->response->expects($this->once())
                       ->method('get_return_code_identifiers')
                       ->with($this->equalTo(TRUE))
                       ->will($this->returnValue('id'));

        $this->response->expects($this->once())
                       ->method('get_error_info')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(4040));

        $this->response->expects($this->once())
                       ->method('get_error_message')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue('Message'));

        $this->response->expects($this->once())
                       ->method('get_return_code')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(404));

        $this->response->expects($this->once())
                       ->method('get_response_data')
                       ->will($this->returnValue($this->json));

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('sapi'))
                      ->will($this->returnValue('cli'));

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/json_complete.json');

        $this->class->print_page();

        $headers = xdebug_get_headers();

        $this->assertInternalType('array', $headers);
        $this->assertNotEmpty($headers);

        $this->assertEquals('ETag: c1210cc1a603c0012f3854d2372341e5b93f85a38357fd7449995278ce188852', $headers[1]);
    }

}

?>
