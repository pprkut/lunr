<?php

/**
 * This file contains the MySQLDMLQueryBuilderDeleteTest class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * delete queries.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder
 */
class MySQLDMLQueryBuilderDeleteTest extends MySQLDMLQueryBuilderTest
{

    /**
     * Test that standard delete modes are handled correctly.
     *
     * @param string $mode Valid delete mode.
     *
     * @dataProvider deleteModesStandardProvider
     * @covers       Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::delete_mode
     */
    public function testDeleteModeSetsStandardCorrectly($mode)
    {
        $property = $this->builder_reflection->getProperty('delete_mode');
        $property->setAccessible(TRUE);

        $this->builder->delete_mode($mode);

        $this->assertContains($mode, $property->getValue($this->builder));
    }

    /**
     * Test that unknown delete modes are ignored.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::delete_mode
     */
    public function testDeleteModeSetsIgnoresUnknownValues()
    {
        $property = $this->builder_reflection->getProperty('delete_mode');
        $property->setAccessible(TRUE);

        $this->builder->delete_mode('UNSUPPORTED');

        $value = $property->getValue($this->builder);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test fluid interface of the delete_mode method.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::delete_mode
     */
    public function testDeleteModeReturnsSelfReference()
    {
        $return = $this->builder->delete_mode('IGNORE');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test delete modes get uppercased properly.
     *
     * @param string $value    Delete mode to set
     * @param string $expected Expected built query part
     *
     * @dataProvider expectedDeleteModesProvider
     * @covers       Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::delete_mode
     */
    public function testDeleteModeCase($value, $expected)
    {
        $property = $this->builder_reflection->getProperty('delete_mode');
        $property->setAccessible(TRUE);

        $this->builder->delete_mode($value);

        $this->assertContains($expected, $property->getValue($this->builder));
    }

}

?>
