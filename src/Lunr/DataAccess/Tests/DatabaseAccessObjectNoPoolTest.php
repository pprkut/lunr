<?php

/**
 * This file contains the DatabaseAccessObjectNoPoolTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\DataAccess\Tests;

use Lunr\DataAccess\DatabaseAccessObject;

/**
 * This class contains the tests for the DatabaseAccessObject class.
 *
 * Base tests for the case where there is no DatabaseConnectionPool.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\DataAccess\DatabaseAccessObject
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
     * @covers Lunr\DataAccess\DatabaseAccessObject::swap_connection
     */
    public function testSwapConnectionSwapsConnection()
    {
        $db = $this->getMockBuilder('Lunr\DataAccess\MySQLConnection')
                         ->disableOriginalConstructor()
                         ->getMock();

        $property = $this->reflection_dao->getProperty('db');
        $property->setAccessible(TRUE);

        $this->assertNotSame($db, $property->getValue($this->dao));

        $this->dao->swap_connection($db);

        $this->assertSame($db, $property->getValue($this->dao));
    }

}

?>
