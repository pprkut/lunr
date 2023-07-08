<?php

/**
 * This file contains the Localization helper trait.
 *
 * It includes shared functions to set the default language and the locales
 * location.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\L10n;

use Psr\Log\LoggerInterface;

/**
 * Localization support trait.
 */
trait L10nTrait
{

    /**
     * Default language.
     * @var string
     */
    protected $default_language;

    /**
     * Locales location.
     * @var string
     */
    protected $locales_location;

    /**
     * Shared instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Set the default language.
     *
     * @param string $language POSIX locale definition
     *
     * @return void
     */
    public function set_default_language($language)
    {
        $current = setlocale(LC_MESSAGES, 0);

        if (setlocale(LC_MESSAGES, $language) !== FALSE)
        {
            $this->default_language = $language;
            setlocale(LC_MESSAGES, $current);
        }
        else
        {
            $this->logger->warning('Invalid default language: ' . $language);
        }
    }

    /**
     * Set the location for language files.
     *
     * @param string $location Path to locale files
     *
     * @return void
     */
    public function set_locales_location($location)
    {
        if (file_exists($location) === TRUE)
        {
            $this->locales_location = $location;
        }
        else
        {
            $this->logger->warning('Invalid locales location: ' . $location);
        }
    }

}

?>
