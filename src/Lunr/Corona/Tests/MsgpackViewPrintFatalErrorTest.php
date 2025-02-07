<?php

/**
 * This file contains the MsgpackViewPrintFatalErrorTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2017 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains tests for the MsgpackView class.
 *
 * @covers     Lunr\Corona\MsgpackView
 */
class MsgpackViewPrintFatalErrorTest extends MsgpackViewTestCase
{

    /**
     * Test that print_fatal_error() does not print an error page if there is no error.
     *
     * @requires extension msgpack
     *
     * @covers   Lunr\Corona\MsgpackView::print_fatal_error
     */
    public function testPrintFatalErrorPrintsNothingIfNoError(): void
    {
        $this->mockFunction('error_get_last', fn() => NULL);

        $this->expectOutputString('');

        $this->class->print_fatal_error();

        $this->unmockFunction('error_get_last');
    }

    /**
     * Test that print_fatal_error() does not print an error page if there is no fatal error.
     *
     * @requires extension msgpack
     *
     * @covers   Lunr\Corona\MsgpackView::print_fatal_error
     */
    public function testPrintFatalErrorPrintsNothingIfErrorNotFatal(): void
    {
        $this->mockFunction('error_get_last', fn() => [ 'type' => 8, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ]);

        $this->expectOutputString('');

        $this->class->print_fatal_error();

        $this->unmockFunction('error_get_last');
    }

    /**
     * Test that print_fatal_error() does prints a msgpack object if there is a fatal error.
     *
     * @requires extension msgpack
     *
     * @covers   Lunr\Corona\MsgpackView::print_fatal_error
     */
    public function testPrintFatalErrorPrintsMsgpack(): void
    {
        $this->mockFunction('error_get_last', fn() => [ 'type' => 1, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ]);
        $this->mockFunction('header', function () {});
        $this->mockFunction('http_response_code', function () {});

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/msgpack_error.msgpack');

        $this->class->print_fatal_error();

        $this->unmockFunction('error_get_last');
        $this->unmockFunction('header');
        $this->unmockFunction('http_response_code');
    }

}

?>
