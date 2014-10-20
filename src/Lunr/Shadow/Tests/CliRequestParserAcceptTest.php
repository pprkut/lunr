<?php

/**
 * This file contains the CliRequestParserAcceptTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @covers     Lunr\Shadow\CliRequestParser
 */
class CliRequestParserAcceptTest extends CliRequestParserTest
{

    /**
     * Test that parse_accept_format() returns content type when called with a valid set of supported formats.
     *
     * @param String $value the expected value
     *
     * @dataProvider contentTypeProvider
     * @requires     extension http
     * @covers       Lunr\Shadow\CliRequestParser::parse_accept_format
     */
    public function testGetAcceptFormatWithValidSupportedFormatsReturnsString($value)
    {
        $this->assertNull($this->header->name);
        $this->assertNull($this->header->value);

        $property = $this->get_accessible_reflection_property('ast');
        $old      = $property->getValue($this->class);
        $new      = $old;

        $new['accept-format'] = [ 'accept_value' ];

        $property->setValue($this->class, $new);

        $this->header->expects($this->once())
                     ->method('negotiate')
                     ->with($this->equalTo($value))
                     ->will($this->returnValue('text/html'));

        $this->assertEquals($value, $this->class->parse_accept_format($value));

        $this->assertSame('Accept', $this->header->name);
        $this->assertSame('accept_value', $this->header->value);
    }

    /**
     * Test that parse_accept_format() returns null when called with an empty set of supported formats.
     *
     * @requires extension http
     * @covers   Lunr\Shadow\CliRequestParser::parse_accept_format
     */
    public function testGetAcceptFormatWithEmptySupportedFormatsReturnsNull()
    {
        $this->assertNull($this->header->name);
        $this->assertNull($this->header->value);

        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['accept-format'] = [ 'accept_value' ];

        $property->setValue($this->class, $ast);

        $this->header->expects($this->once())
                     ->method('negotiate')
                     ->with($this->equalTo([]))
                     ->will($this->returnValue(NULL));

        $this->assertNull($this->class->parse_accept_format([]));

        $this->assertSame('Accept', $this->header->name);
        $this->assertSame('accept_value', $this->header->value);
    }

    /**
     * Test that parse_accept_language() returns content type when called with a valid set of supported languages.
     *
     * @param String $value the expected value
     *
     * @dataProvider acceptLanguageProvider
     * @requires     extension http
     * @covers       Lunr\Shadow\CliRequestParser::parse_accept_language
     */
    public function testGetAcceptLanguageWithValidSupportedLanguagesReturnsString($value)
    {
        $this->assertNull($this->header->name);
        $this->assertNull($this->header->value);

        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['accept-language'] = [ 'accept_language_value' ];

        $property->setValue($this->class, $ast);

        $this->header->expects($this->once())
                     ->method('negotiate')
                     ->with($this->equalTo($value))
                     ->will($this->returnValue('en-US'));

        $this->assertEquals($value, $this->class->parse_accept_language($value));

        $this->assertSame('Accept-Language', $this->header->name);
        $this->assertSame('accept_language_value', $this->header->value);
    }

    /**
     * Test that parse_accept_format() returns null when called with an empty set of supported languages.
     *
     * @requires extension http
     * @covers   Lunr\Shadow\CliRequestParser::parse_accept_language
     */
    public function testGetAcceptLanguageWithEmptySupportedLanguagesReturnsNull()
    {
        $this->assertNull($this->header->name);
        $this->assertNull($this->header->value);

        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['accept-language'] = [ 'accept_language_value' ];

        $property->setValue($this->class, $ast);

        $this->header->expects($this->once())
                     ->method('negotiate')
                     ->with($this->equalTo([]))
                     ->will($this->returnValue(NULL));

        $this->assertNull($this->class->parse_accept_language([]));

        $this->assertSame('Accept-Language', $this->header->name);
        $this->assertSame('accept_language_value', $this->header->value);
    }

    /**
     * Test that parse_accept_charset() returns content type when called with a valid set of supported charsets.
     *
     * @param String $value the expected value
     *
     * @dataProvider acceptCharsetProvider
     * @requires     extension http
     * @covers       Lunr\Shadow\CliRequestParser::parse_accept_charset
     */
    public function testGetAcceptCharsetWithValidSupportedCharsetsReturnsString($value)
    {
        $this->assertNull($this->header->name);
        $this->assertNull($this->header->value);

        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['accept-charset'] = [ 'accept_charset_value' ];

        $property->setValue($this->class, $ast);

        $this->header->expects($this->once())
                     ->method('negotiate')
                     ->with($this->equalTo($value))
                     ->will($this->returnValue('utf-8'));

        $this->assertEquals($value, $this->class->parse_accept_charset($value));

        $this->assertSame('Accept-Charset', $this->header->name);
        $this->assertSame('accept_charset_value', $this->header->value);
    }

    /**
     * Test that parse_accept_charset() returns null when called with an empty set of supported charsets.
     *
     * @requires extension http
     * @covers   Lunr\Shadow\CliRequestParser::parse_accept_charset
     */
    public function testGetAcceptCharsetWithEmptySupportedCharsetsReturnsNull()
    {
        $this->assertNull($this->header->name);
        $this->assertNull($this->header->value);

        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['accept-charset'] = [ 'accept_charset_value' ];

        $property->setValue($this->class, $ast);

        $this->header->expects($this->once())
                     ->method('negotiate')
                     ->with($this->equalTo([]))
                     ->will($this->returnValue(NULL));

        $this->assertNull($this->class->parse_accept_charset([]));

        $this->assertSame('Accept-Charset', $this->header->name);
        $this->assertSame('accept_charset_value', $this->header->value);
    }

}

?>
