<?php

/**
 * SQLite3 database query builder class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Gravity\Database\SQLite3
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3;

use Lunr\Gravity\Database\SQLDMLQueryBuilder;

/**
 * This is a SQL query builder class for generating queries suitable for SQLite3.
 */
class SQLite3DMLQueryBuilder extends SQLDMLQueryBuilder
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Construct and return a INSERT query.
     *
     * @return string $query The constructed query string.
     */
    public function get_insert_query()
    {
        if ($this->into == '')
        {
            return '';
        }

        $components   = [];
        $components[] = 'insert_mode';
        $components[] = 'into';
        $components[] = 'column_names';

        if ($this->select_statement != '')
        {
            $components[] = 'select_statement';
        }
        else
        {
            $components[] = 'values';
        }

        return 'INSERT ' . $this->implode_query($components);
    }

    /**
     * Construct and return a REPLACE query.
     *
     * @return string $query The constructed query string.
     */
    public function get_replace_query()
    {
        if ($this->into == '')
        {
            return '';
        }

        $components   = [];
        $components[] = 'into';
        $components[] = 'column_names';

        if ($this->select_statement != '')
        {
            $components[] = 'select_statement';
        }
        else
        {
            $components[] = 'values';
        }

        return 'REPLACE ' . $this->implode_query($components);
    }

    /**
     * Not supported by SQLite.
     *
     * @param string $mode The delete mode you want to use
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function delete_mode($mode)
    {
        return $this;
    }

    /**
     * Define the mode of the INSERT clause.
     *
     * @param string $mode The insert mode you want to use
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function insert_mode($mode)
    {
        $mode = strtoupper($mode);

        switch ($mode)
        {
            case 'OR ROLLBACK':
            case 'OR ABORT':
            case 'OR REPLACE':
            case 'OR FAIL':
            case 'OR IGNORE':
                $this->insert_mode['mode'] = $mode;
                break;
            default:
                break;
        }

        return $this;
    }

    /**
     * Not supported by sqlite.
     *
     * @param string $mode The replace mode you want to use
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function replace_mode($mode)
    {
        return $this;
    }

    /**
     * Define the mode of the SELECT clause.
     *
     * @param string $mode The select mode you want to use
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function select_mode($mode)
    {
        $mode = strtoupper($mode);

        switch ($mode)
        {
            case 'ALL':
            case 'DISTINCT':
                $this->select_mode['duplicates'] = $mode;
                break;
            default:
                break;
        }

        return $this;
    }

    /**
     * Define the mode of the UPDATE clause.
     *
     * @param string $mode The update mode you want to use
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function update_mode($mode)
    {
        $mode = strtoupper($mode);

        switch ($mode)
        {
            case 'OR ROLLBACK':
            case 'OR ABORT':
            case 'OR REPLACE':
            case 'OR FAIL':
            case 'OR IGNORE':
                $this->update_mode['mode'] = $mode;
            default:
                break;
        }

        return $this;
    }

    /**
     * Define ON part of a JOIN clause with REGEXP comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the comparison or not
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function on_regexp($left, $right, $negate = FALSE)
    {
        $operator = ($negate === FALSE) ? 'REGEXP' : 'NOT REGEXP';
        $this->sql_condition($left, $right, $operator, 'ON');
        return $this;
    }

    /**
     * Define WHERE clause with the REGEXP condition of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the condition or not
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function where_regexp($left, $right, $negate = FALSE)
    {
        $operator = ($negate === FALSE) ? 'REGEXP' : 'NOT REGEXP';
        $this->sql_condition($left, $right, $operator);
        return $this;
    }

    /**
     * Define GROUP BY clause of the SQL statement.
     *
     * @param string  $expr  Expression to group by
     * @param boolean $order Not supported by SQLite
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function group_by($expr, $order = NULL)
    {
        $this->sql_group_by($expr);
        return $this;
    }

    /**
     * Define HAVING clause with REGEXP comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the comparison or not
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function having_regexp($left, $right, $negate = FALSE)
    {
        $operator = ($negate === FALSE) ? 'REGEXP' : 'NOT REGEXP';
        $this->sql_condition($left, $right, $operator, 'HAVING');
        return $this;
    }

    /**
     * Not supported by SQLite.
     *
     * @param string $mode The lock mode you want to use
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function lock_mode($mode)
    {
        return $this;
    }

}

?>
