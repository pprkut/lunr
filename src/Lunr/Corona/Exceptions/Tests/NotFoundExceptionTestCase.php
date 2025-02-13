<?php

/**
 * This file contains the NotFoundExceptionTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2023 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Exceptions\Tests;

use Exception;
use Lunr\Corona\Exceptions\NotFoundException;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the NotFoundException class.
 *
 * @covers Lunr\Corona\Exceptions\NotFoundException
 */
abstract class NotFoundExceptionTestCase extends LunrBaseTestCase
{

    /**
     * Previous exception.
     * @var Exception
     */
    protected $previous;

    /**
     * Error message.
     * @var string
     */
    protected $message;

    /**
     * Application error code.
     * @var int
     */
    protected $code;

    /**
     * Instance of the tested class.
     * @var NotFoundException
     */
    protected NotFoundException $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->message = 'Http error!';
        $this->code    = 9999;

        $this->previous = new Exception();

        $this->class = new NotFoundException($this->message, $this->code, $this->previous);

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->code);
        unset($this->message);
        unset($this->previous);
        unset($this->class);

        parent::tearDown();
    }

}

?>
