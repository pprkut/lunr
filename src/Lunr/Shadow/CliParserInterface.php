<?php

/**
 * This file contains an interface for command line argument parsers.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow;

/**
 * Command line argument parser interface.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
interface CliParserInterface
{

    /**
     * Parse command line parameters.
     *
     * @return array $args Array of parameters and their arguments
     */
    public function parse();

    /**
     * Check whether the parsed command line was valid or not.
     *
     * @return boolean $invalid TRUE if the command line was invalid, FALSE otherwise
     */
    public function is_invalid_commandline();

}

?>
