<?php

/**
 * This file contains the PsrLoggerTestTrait.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Halo
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Halo\PropertyTraits;

/**
 * This trait contains test methods to verify a PSR-3 compliant logger was passed correctly.
 */
trait PsrLoggerTestTrait
{

    /**
     * Test that the Logger class is passed correctly.
     */
    public function testLoggerIsSetCorrectly()
    {
        $property = $this->get_reflection_property_value('logger');

        $this->assertSame($property, $this->logger);
        $this->assertInstanceOf('Psr\Log\LoggerInterface', $property);
    }

}

?>
