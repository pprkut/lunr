<?php

/**
 * This file contains the PaginationTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Surface
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Surface\Tests;
use Lunr\Surface\Pagination;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains the tests for the Pagination class.
 *
 * @category   Libraries
 * @package    Surface
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Surface\Pagination
 */
abstract class PaginationTest extends PHPUnit_Framework_TestCase
{

    /**
     * Mock instance of the Request class.
     * @var Request
     */
    protected $request;

    /**
     * Reflection instance of the Pagination class.
     * @var ReflectionClass
     */
    protected $reflection_pagination;

    /**
     * Instance of the Pagination class.
     * @var Pagination
     */
    protected $pagination;

    /**
     * Test Case Constructor.
     *
     * @return void
     */
    public function setUpWithoutCursor()
    {
        $this->request = $this->getMockBuilder('Lunr\Core\Request')
                              ->disableOriginalConstructor()
                              ->getMock();

        $map = array(
            array('base_url', 'http://www.example.com'),
            array('controller', 'controller'),
            array('method', 'method'),
            array('params', array('param1', 'param2'))
        );

        $this->request->expects($this->exactly(4))
                      ->method('__get')
                      ->will($this->returnValueMap($map));

        $this->reflection_pagination = new ReflectionClass('Lunr\Surface\Pagination');

        $this->pagination = new Pagination($this->request);
    }

    /**
     * Test Case Constructor.
     *
     * @return void
     */
    public function setUpWithCursor()
    {
        $this->request = $this->getMockBuilder('Lunr\Core\Request')
                              ->disableOriginalConstructor()
                              ->getMock();

        $map = array(
            array('base_url', 'http://www.example.com'),
            array('controller', 'controller'),
            array('method', 'method'),
            array('params', array('param1', 'param2', '1'))
        );

        $this->request->expects($this->exactly(4))
                      ->method('__get')
                      ->will($this->returnValueMap($map));

        $this->reflection_pagination = new ReflectionClass('Lunr\Surface\Pagination');

        $this->pagination = new Pagination($this->request);
    }

    /**
     * Test Case Destructor.
     */
    public function tearDown()
    {
        unset($this->request);
        unset($this->reflection_pagination);
        unset($this->pagination);
    }

}

?>
