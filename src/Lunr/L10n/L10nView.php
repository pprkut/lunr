<?php

/**
 * This file contains a view class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n;

use Lunr\Corona\View;

/**
 * View class used by the Website
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
abstract class L10nView extends View
{

    /**
     * Shared instance of the Localization provider
     * @var L10nProvider
     */
    protected $l10n;

    /**
     * Constructor.
     *
     * @param Request       $request       Shared instance of the Request class
     * @param Response      $response      Shared instance of the Response class
     * @param Configuration $configuration Shared instance of to the Configuration class
     * @param L10nProvider  $l10nprovider  Shared instance of the L10nProvider class
     */
    public function __construct($request, $response, $configuration, $l10nprovider)
    {
        parent::__construct($request, $response, $configuration);

        $this->l10n = $l10nprovider;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->l10n);

        parent::__destruct();
    }

}

?>
