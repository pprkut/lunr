<?php

/**
 * This file contains the BearerTokenParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\BearerToken\Tests;

use Lunr\Corona\Parsers\BearerToken\BearerTokenParser;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains test methods for the BearerTokenParser class.
 *
 * @covers Lunr\Corona\Parsers\BearerToken\BearerTokenParser
 */
abstract class BearerTokenParserTestCase extends LunrBaseTestCase
{

    /**
     * Instance of the tested class.
     * @var BearerTokenParser
     */
    protected BearerTokenParser $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new BearerTokenParser();

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);

        parent::tearDown();
    }

}

?>
