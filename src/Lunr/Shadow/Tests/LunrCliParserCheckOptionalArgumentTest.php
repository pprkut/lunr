<?php

/**
 * This file contains the LunrCliParserCheckOptionalArgumentTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

/**
 * This class contains test methods for check_arguments() in the LunrCliParser class.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Shadow\LunrCliParser
 */
class LunrCliParserCheckOptionalArgumentTest extends LunrCliParserTest
{

    /**
     * Test that check_argument() returns TRUE for a valid parameter with one argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsTrueForValidParameterWithOneArg()
    {
        $this->set_reflection_property_value('args', array('test.php', '-c', 'arg'));

        $this->set_reflection_property_value('ast', array('c' => array()));

        $method = $this->get_accessible_reflection_method('check_argument');

        $value = $method->invokeArgs($this->class, array('c', 1, 0, 'c;'));

        $this->assertTrue($value);
    }

    /**
     * Test that check_argument() returns TRUE for a valid parameter with one argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsTrueForValidParameterWithTwoArgs()
    {
        $this->set_reflection_property_value('args', array('test.php', '-f', 'arg1', 'arg2'));

        $this->set_reflection_property_value('ast', array('f' => array()));

        $method = $this->get_accessible_reflection_method('check_argument');

        $value = $method->invokeArgs($this->class, array('f', 1, 0, 'f;;'));

        $this->assertTrue($value);
    }

    /**
     * Test that check_argument() appends first argument to ast.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentAppendsFirstArgumentToAst()
    {
        $this->set_reflection_property_value('args', array('test.php', '-c', 'arg'));

        $this->set_reflection_property_value('ast', array('c' => array()));

        $method = $this->get_accessible_reflection_method('check_argument');

        $method->invokeArgs($this->class, array('c', 1, 0, 'c;'));

        $value = $this->get_reflection_property_value('ast');

        $this->assertCount(1, $value['c']);
        $this->assertEquals(array('arg'), $value['c']);
    }

    /**
     * Test that check_argument() appends first argument to ast.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentAppendsSecondArgumentToAst()
    {
        $this->set_reflection_property_value('args', array('test.php', '-f', 'arg1', 'arg2'));

        $this->set_reflection_property_value('ast', array('f' => array()));

        $method = $this->get_accessible_reflection_method('check_argument');

        $method->invokeArgs($this->class, array('f', 1, 0, 'f;;'));

        $value = $this->get_reflection_property_value('ast');

        $this->assertCount(2, $value['f']);
        $this->assertEquals(array('arg1', 'arg2'), $value['f']);
    }

    /**
     * Test that check_argument() returns FALSE when the argument is missing.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsFalseForArgumentMissing()
    {
        $this->set_reflection_property_value('args', array('test.php', '-b'));

        $this->set_reflection_property_value('ast', array('b' => array()));

        $method = $this->get_accessible_reflection_method('check_argument');

        $this->console->expects($this->never())
                      ->method('cli_println');

        $value = $method->invokeArgs($this->class, array('b', 1, 0, 'b;'));

        $this->assertFalse($value);
    }

    /**
     * Test that check_argument() returns FALSE when the argument is missing.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsFalseForArgumentMissingWithAnotherParameterAfter()
    {
        $this->set_reflection_property_value('args', array('test.php', '-b', '-c'));

        $this->set_reflection_property_value('ast', array('b' => array()));

        $method = $this->get_accessible_reflection_method('check_argument');

        $this->console->expects($this->never())
                      ->method('cli_println');

        $value = $method->invokeArgs($this->class, array('b', 1, 0, 'b;'));

        $this->assertFalse($value);
    }

}

?>
