<?php

/**
 * This file contains the PAPPayloadBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\PAP
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\PAP\Tests;

/**
 * This class contains the Base tests of the GCMPayload class.
 *
 * @covers Lunr\Vortex\PAP\PAPPayload
 */
class PAPPayloadBaseTest extends PAPPayloadTest
{

    /**
     * Test elements is initialized as an empty array.
     */
    public function testElementsIsInitializedAsEmptyArray()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('data'));
    }

}

?>
