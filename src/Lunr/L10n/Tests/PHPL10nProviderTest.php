<?php

/**
 * This file contains the PHPL10nProviderTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\L10n\Tests;

use Lunr\L10n\PHPL10nProvider;
use Lunr\Halo\LunrBaseTest;
use Psr\Log\LoggerInterface;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the PHPL10nProvider class.
 *
 * @covers Lunr\L10n\PHPL10nProvider
 */
abstract class PHPL10nProviderTest extends LunrBaseTest
{

    /**
     * Mock Object for a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * The language used for testing.
     * @var string
     */
    protected const LANGUAGE = 'de_DE';

    /**
     * The domain used for testing.
     * @var string
     */
    private const DOMAIN = 'Lunr';

    /**
     * TestCase Constructor.
     *
     * Setup a plain (empty) PHPL10nProvider
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->reflection = new ReflectionClass('Lunr\L10n\PHPL10nProvider');

        $this->class = new PHPL10nProvider(self::LANGUAGE, self::DOMAIN, $this->logger);
        $this->class->set_locales_location(TEST_STATICS . '/l10n');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->logger);
    }

}

?>
