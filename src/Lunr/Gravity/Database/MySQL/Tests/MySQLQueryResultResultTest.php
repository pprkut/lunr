<?php

/**
 * This file contains the MySQLQueryResultResultTest class.
 *
 * PHP Version 5.3
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLQueryResult;

/**
 * This class contains tests for the MySQLQueryResult class
 * based on a successful query with result.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLQueryResult
 */
class MySQLQueryResultResultTest extends MySQLQueryResultTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->resultSetSetup();
    }

    /**
     * Test that the success flag is TRUE.
     *
     * @requires extension mysqli
     */
    public function testSuccessIsTrue()
    {
        $property = $this->result_reflection->getProperty('success');
        $property->setAccessible(TRUE);

        $this->assertTrue($property->getValue($this->result));
    }

    /**
     * Test that the freed flasg is FALSE.
     *
     * @requires extension mysqli
     */
    public function testFreedIsFalse()
    {
        $property = $this->result_reflection->getProperty('freed');
        $property->setAccessible(TRUE);

        $this->assertFalse($property->getValue($this->result));
    }

    /**
     * Test that the has_failed() method returns FALSE.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLQueryResult::has_failed
     */
    public function testHasFailedReturnsFalse()
    {
        $this->assertFalse($this->result->has_failed());
    }

    /**
     * Test that number_of_rows() returns a number.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLQueryResult::number_of_rows
     */
    public function testNumberOfRowsReturnsNumber()
    {
        $class = $this->result_reflection->getProperty('num_rows');
        $class->setAccessible(TRUE);
        $class->setValue($this->result, 5);

        $value = $this->result->number_of_rows();
        $this->assertInternalType('int', $value);
        $this->assertEquals(5, $value);
    }

    /**
     * Test that result_array() returns an multidimensional array.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_array
     */
    public function testResultArrayReturnsArray()
    {
        $result = array(0 => array('col1' => 'val1', 'col2' => 'val2'), 1 => array('col1' => 'val3', 'col2' => 'val4'));

        $this->query_result->expects($this->at(0))
                           ->method('fetch_assoc')
                           ->will($this->returnValue($result[0]));
        $this->query_result->expects($this->at(1))
                           ->method('fetch_assoc')
                           ->will($this->returnValue($result[1]));
        $this->query_result->expects($this->at(2))
                           ->method('fetch_assoc')
                           ->will($this->returnValue(NULL));
        $value = $this->result->result_array();

        $this->assertInternalType('array', $value);
        $this->assertEquals($result, $value);
    }

    /**
     * Test that result_row() returns an one-dimensional array.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_row
     */
    public function testResultRowReturnsArray()
    {
        $result = array('col1' => 'val1', 'col2' => 'val2');
        $this->query_result->expects($this->once())
                           ->method('fetch_assoc')
                           ->will($this->returnValue($result));

        $value = $this->result->result_row();

        $this->assertInternalType('array', $value);
        $this->assertEquals($result, $value);
    }

    /**
     * Test that result_column() returns an one-dimensional array.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_column
     */
    public function testResultColumnReturnsArray()
    {
        $this->query_result->expects($this->at(0))
                           ->method('fetch_assoc')
                           ->will($this->returnValue(array('col1' => 'val1', 'col2' => 'val2')));
        $this->query_result->expects($this->at(1))
                           ->method('fetch_assoc')
                           ->will($this->returnValue(array('col1' => 'val3', 'col2' => 'val4')));
        $this->query_result->expects($this->at(2))
                           ->method('fetch_assoc')
                           ->will($this->returnValue(NULL));
        $value = $this->result->result_column('col1');

        $this->assertInternalType('array', $value);
        $this->assertEquals(array('val1', 'val3'), $value);
    }

    /**
     * Test that result_cell() returns value.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_cell
     */
    public function testResultCellReturnsValue()
    {
        $this->query_result->expects($this->once())
                           ->method('fetch_assoc')
                           ->will($this->returnValue(array('cell' => 'value')));

        $this->assertEquals('value', $this->result->result_cell('cell'));
    }

    /**
     * Test that result_cell() returns NULL if the column doesn't exist.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_cell
     */
    public function testResultCellReturnsNullIfColumnDoesNotExist()
    {
        $this->query_result->expects($this->once())
                           ->method('fetch_assoc')
                           ->will($this->returnValue(array('cell' => 'value')));

        $this->assertNull($this->result->result_cell('cell1'));
    }

}

?>
