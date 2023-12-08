<?php

/**
 * This file contains the abstract definition for the
 * Gettext Localization Provider.
 *
 * SPDX-FileCopyrightText: Copyright 2010 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\L10n;

use Psr\Log\LoggerInterface;

/**
 * Gettext Localization Provider class
 */
class GettextL10nProvider extends L10nProvider
{

    /**
     * Define gettext msgid size limit
     * @var int
     */
    private const GETTEXT_MAX_MSGID_LENGTH = 4096;

    /**
     * Constructor.
     *
     * @param string          $language         POSIX locale definition
     * @param string          $domain           Localization domain
     * @param LoggerInterface $logger           Shared instance of a logger class
     * @param string          $locales_location Location of translation files
     */
    public function __construct($language, $domain, $logger, $locales_location)
    {
        parent::__construct($language, $domain, $logger, $locales_location);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Initialization method for setting up the provider.
     *
     * @param string $language POSIX locale definition
     *
     * @return void
     */
    protected function init($language)
    {
        setlocale(LC_MESSAGES, $language);
        bindtextdomain($this->domain, $this->locales_location);
        textdomain($this->domain);
    }

    /**
     * Return a translated string.
     *
     * @param string $identifier Identifier for the requested string
     * @param string $context    Context information fot the requested string
     *
     * @return string $string Translated string, identifier by default
     */
    public function lang($identifier, $context = '')
    {
        if (strlen($identifier) + strlen($context) + 1 > self::GETTEXT_MAX_MSGID_LENGTH)
        {
            $this->logger->warning('Identifier too long: ' . $identifier);

            return $identifier;
        }

        $this->init($this->language);

        if ($context == '')
        {
            return gettext($identifier);
        }

        // Glue msgctxt and msgid together, with ASCII character 4
        // (EOT, End Of Text)
        $composed = "{$context}\004{$identifier}";
        $output   = dcgettext($this->domain, $composed, LC_MESSAGES);

        if (($output == $composed) && ($this->language != $this->default_language))
        {
            return $identifier;
        }
        else
        {
            return $output;
        }
    }

    /**
     * Return a translated string, with proper singular/plural form.
     *
     * @param string $singular Identifier for the singular version of
     *                         the string
     * @param string $plural   Identifier for the plural version of
     *                         the string
     * @param int    $amount   The amount the translation should be based on
     * @param string $context  Context information fot the requested string
     *
     * @return string $string Translated string, identifier by default
     */
    public function nlang($singular, $plural, $amount, $context = '')
    {
        if (strlen($singular) + strlen($context) + 1 > self::GETTEXT_MAX_MSGID_LENGTH)
        {
            $this->logger->warning('Identifier too long: ' . $singular);

            return $singular;
        }

        $this->init($this->language);

        if ($context == '')
        {
            return ngettext($singular, $plural, $amount);
        }

        // Glue msgctxt and msgid together, with ASCII character 4
        // (EOT, End Of Text)
        $composed = "{$context}\004{$singular}";
        $output   = dcngettext($this->domain, $composed, $plural, $amount, LC_MESSAGES);

        if ((($output == $composed) || ($output == $plural))
            && ($this->language != $this->default_language)
        )
        {
            return ($amount == 1 ? $singular : $plural);
        }
        else
        {
            return $output;
        }
    }

}

?>
