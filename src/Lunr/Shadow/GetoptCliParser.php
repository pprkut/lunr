<?php

/**
 * This file contains a getopt-based command line argument parser.
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
 * Getopt command line argument parser.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class GetoptCliParser implements CliParserInterface
{

    /**
     * String defining all possible short options (1 character)
     * @var String
     */
    private $short;

    /**
     * Array containing all possible long options
     * @var array
     */
    private $long;

    /**
     * Whether there has been a parse error or not
     * @var boolean
     */
    private $error;

    /**
     * Constructor.
     *
     * @param String $shortopts List of supported short arguments
     * @param array  $longopts  List of supported long arguments (optional)
     */
    public function __construct($shortopts, $longopts = '')
    {
        $this->short = $shortopts;
        $this->long  = $longopts;
        $this->error = FALSE;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->short);
        unset($this->long);
        unset($this->error);
    }

    /**
     * Parse command line arguments.
     *
     * @return array $ast The ast of the parsed arguments
     */
    public function parse()
    {
        $raw = getopt($this->short, $this->long);

        if ($raw === FALSE)
        {
            $this->error = TRUE;
            return array();
        }

        $ast = array_map(array($this, 'wrap_argument'), $raw);

        return $ast;
    }

    /**
     * Parse error information.
     *
     * @return boolean $error Whether there was a parse error or not
     */
    public function is_invalid_commandline()
    {
        return $this->error;
    }

    /**
     * Wrap parsed command line arguments in a unified format.
     *
     * @param mixed $value Parsed command line argument
     *
     * @return array $return Wrapped argument
     */
    protected function wrap_argument($value)
    {
        if ($value === FALSE)
        {
            return array();
        }
        else
        {
            return array($value);
        }
    }

}

?>
