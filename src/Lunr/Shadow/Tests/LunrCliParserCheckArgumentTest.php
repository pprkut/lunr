<?php

/**
 * This file contains the LunrCliParserCheckArgumentTest class.
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
class LunrCliParserCheckArgumentTest extends LunrCliParserTest
{

    /**
     * Test that check_argument() returns FALSE for a valid parameter without arguments.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsFalseForValidParameterWithoutArgs()
    {
        $method = $this->get_accessible_reflection_method('check_argument');

        $value = $method->invokeArgs($this->class, array('a', 1, 0, 'a'));

        $this->assertFalse($value);
    }

    /**
     * Test that check_argument() returns TRUE for a superfluous argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsTrueForSuperfluousArgument()
    {
        $this->set_reflection_property_value('args', array('test.php', '-a', 'arg'));

        $method = $this->get_accessible_reflection_method('check_argument');

        $this->console->expects($this->once())
                      ->method('cli_println')
                      ->with($this->equalTo('Superfluous argument: arg'));

        $value = $method->invokeArgs($this->class, array('a', 1, 0, 'a'));

        $this->assertTrue($value);
    }

}

?>
