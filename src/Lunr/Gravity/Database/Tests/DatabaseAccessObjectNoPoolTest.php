<?php

/**
 * This file contains the DatabaseAccessObjectNoPoolTest class.
 *
 * PHP Version 5.4
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseAccessObject;

/**
 * This class contains the tests for the DatabaseAccessObject class.
 *
 * Base tests for the case where there is no DatabaseConnectionPool.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\DatabaseAccessObject
 */
class DatabaseAccessObjectNoPoolTest extends DatabaseAccessObjectTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->setUpNoPool();
    }

    /**
     * Test that DatabaseConnection class is passed.
     */
    public function testDatabaseConnectionIsPassed()
    {
        $property = $this->reflection_dao->getProperty('db');
        $property->setAccessible(TRUE);

        $this->assertSame($this->db, $property->getValue($this->dao));
    }

    /**
     * Test that Logger class is passed by reference.
     */
    public function testLoggerIsPassed()
    {
        $property = $this->reflection_dao->getProperty('logger');
        $property->setAccessible(TRUE);

        $this->assertSame($this->logger, $property->getValue($this->dao));
    }

    /**
     * Test that DatabaseConnection class is passed.
     */
    public function testQueryEscaperIsStored()
    {
        $property = $this->reflection_dao->getProperty('escaper');
        $property->setAccessible(TRUE);

        $this->assertInstanceOf('Lunr\Gravity\Database\DatabaseQueryEscaper', $property->getValue($this->dao));
    }

    /**
     * Test that $pool is NULL.
     */
    public function testDatabaseConnectionPoolIsNull()
    {
        $property = $this->reflection_dao->getProperty('pool');
        $property->setAccessible(TRUE);

        $this->assertNull($property->getValue($this->dao));
    }

    /**
     * Test that swap_connection() swaps database connections.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::swap_connection
     */
    public function testSwapConnectionSwapsConnection()
    {
        $db = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLConnection')
                   ->disableOriginalConstructor()
                   ->getMock();

        $property = $this->reflection_dao->getProperty('db');
        $property->setAccessible(TRUE);

        $this->assertNotSame($db, $property->getValue($this->dao));

        $this->dao->swap_connection($db);

        $this->assertSame($db, $property->getValue($this->dao));
    }

    /**
     * Test that swap_connection() swaps query escaper.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::swap_connection
     */
    public function testSwapConnectionSwapsQueryEscaper()
    {
        $db = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLConnection')
                   ->disableOriginalConstructor()
                   ->getMock();

        $escaper = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryEscaper')
                        ->disableOriginalConstructor()
                        ->getMock();

        $property = $this->reflection_dao->getProperty('escaper');
        $property->setAccessible(TRUE);

        $old = $property->getValue($this->dao);

        $db->expects($this->once())
           ->method('get_query_escaper_object')
           ->will($this->returnValue($escaper));

        $this->dao->swap_connection($db);

        $new = $property->getValue($this->dao);

        $this->assertNotSame($old, $new);
        $this->assertInstanceOf('Lunr\Gravity\Database\DatabaseQueryEscaper', $new);
    }

}

?>
