<?php

/**
 * This file contains the MPNSTilePayloadTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS\Tests;

use Lunr\Vortex\MPNS\MPNSTilePayload;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the MPNSTilePayload class.
 *
 * @covers Lunr\Vortex\MPNS\MPNSTilePayload
 */
abstract class MPNSTilePayloadTest extends LunrBaseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->class = new MPNSTilePayload();

        $this->reflection = new ReflectionClass('Lunr\Vortex\MPNS\MPNSTilePayload');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
    }

}

?>
