<?php

/**
 * This file contains the MySQLConnectionBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Halo\PsrLoggerTestTrait;

/**
 * This class contains basic tests for the MySQLConnection class.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLConnection
 */
class MySQLConnectionBaseTest extends MySQLConnectionTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the mysqli class was passed correctly.
     */
    public function testMysqliPassed()
    {
        $this->assertPropertySame('mysqli', $this->mysqli);
    }

    /**
     * Test that rw_host is set correctly.
     */
    public function testRWHostIsSetCorrectly()
    {
        $this->assertPropertyEquals('rw_host', 'rw_host');
    }

    /**
     * Test that ro_host is set to rw_host.
     */
    public function testROHostIsSetToRWHost()
    {
        $this->assertPropertyEquals('ro_host', 'rw_host');
    }

    /**
     * Test that username is set correctly.
     */
    public function testUsernameIsSetCorrectly()
    {
        $this->assertPropertyEquals('user', 'username');
    }

    /**
     * Test that password is set correctly.
     */
    public function testPasswordIsSetCorrectly()
    {
        $this->assertPropertyEquals('pwd', 'password');
    }

    /**
     * Test that database is set correctly.
     */
    public function testDatabaseIsSetCorrectly()
    {
        $this->assertPropertyEquals('db', 'database');
    }

    /**
     * Test that the value for port is taken from the php ini.
     */
    public function testPortMatchesValueInPHPIni()
    {
        $this->assertPropertyEquals('port', ini_get('mysqli.default_port'));
    }

    /**
     * Test that the value for socket is taken from the php ini.
     */
    public function testSocketMatchesValueInPHPIni()
    {
        $this->assertPropertyEquals('socket', ini_get('mysqli.default_socket'));
    }

    /**
     * Test that database is set correctly.
     */
    public function testQueryHintIsEmpty()
    {
        $this->assertPropertySame('query_hint', '');
    }

    /**
     * Test that database is set correctly.
     *
     * @requires extension mysqlnd_ms
     */
    public function testQoSPolicyIsSetToDefaultPolicy()
    {
        $this->assertPropertySame('qos_policy', MYSQLND_MS_QOS_CONSISTENCY_EVENTUAL);
    }

    /**
     * Test that get_new_dml_query_builder_object() returns a new object.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::get_new_dml_query_builder_object
     */
    public function testGetNewDMLQueryBuilderObjectSimpleReturnsObject()
    {
        $value = $this->class->get_new_dml_query_builder_object();

        $this->assertInstanceOf('Lunr\Gravity\Database\DatabaseDMLQueryBuilder', $value);
        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $value);
        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder', $value);
    }

    /**
     * Test that get_new_dml_query_builder_object() returns a new object.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::get_new_dml_query_builder_object
     */
    public function testGetNewDMLQueryBuilderObjectReturnsObject()
    {
        $value = $this->class->get_new_dml_query_builder_object(FALSE);

        $this->assertInstanceOf('Lunr\Gravity\Database\DatabaseDMLQueryBuilder', $value);
        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $value);
        $this->assertNotInstanceOf('Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder', $value);
    }

    /**
     * Test that get_query_escaper_object() returns a new object.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::get_query_escaper_object
     */
    public function testGetQueryEscaperObjectReturnsObject()
    {
        $value = $this->class->get_query_escaper_object();

        $this->assertInstanceOf('Lunr\Gravity\Database\DatabaseQueryEscaper', $value);
        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLQueryEscaper', $value);
    }

    /**
     * Test that get_query_escaper_object() returns a new object.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::get_query_escaper_object
     */
    public function testGetQueryEscaperObjectCachesObject()
    {
        $property = $this->get_accessible_reflection_property('escaper');
        $this->assertNull($property->getValue($this->class));

        $this->class->get_query_escaper_object();

        $instance = 'Lunr\Gravity\Database\MySQL\MySQLQueryEscaper';
        $this->assertInstanceOf($instance, $property->getValue($this->class));
    }

    /**
     * Test that get_query_escaper_object() returns a new object.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::get_query_escaper_object
     */
    public function testGetQueryEscaperObjectReturnsCachedObject()
    {
        $value1 = $this->class->get_query_escaper_object();
        $value2 = $this->class->get_query_escaper_object();

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLQueryEscaper', $value1);
        $this->assertSame($value1, $value2);
    }

}

?>
