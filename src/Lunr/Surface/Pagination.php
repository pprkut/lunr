<?php

/**
 * This file contains the Pagination class. Pagination takes an
 * array of data items, splits them among multiple HTML pages
 * and makes them accessible via a navigation interface.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Surface
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Javier Negre <javi@m2mobi.com>
 * @copyright  2010-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Surface;

/**
 * Pagination class
 *
 * @category   Libraries
 * @package    Surface
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Javier Negre <javi@m2mobi.com>
 */
class Pagination
{

    /**
     * The maximum number of pages that the pagination class
     * can support. We compare the current cursor against this
     * constant.
     *
     * @var Integer
     */
    const MAX_PAGES = 250;

    /**
     * Cursor pointing to the currently displayed page
     * @var Integer
     */
    private $cursor;

    /**
     * Pagination base url
     * @var String
     */
    private $base_url;

    /**
     * Total number of items
     * @var Integer
     */
    private $total;

    /**
     * Numbers of items shown per page
     * @var Integer
     */
    private $per_page;

    /**
     * Total amount of pages
     * @var Integer
     */
    private $pages_total;

    /**
     * Page links shown before and after the cursor
     * @var Integer
     */
    private $range;

    /**
     * Button Information
     * @var array
     */
    private $buttons;

    /**
     * Constructor.
     *
     * @param Request &$request reference to the request class
     */
    public function __construct(&$request)
    {
        // Default values
        $this->per_page     = 25;
        $this->range        =  2;
        $this->total        = -1;
        $this->pages_total  =  0;

        $params = $request->params;
        $cursor = end($params);
        if (is_int($cursor))
        {
            $this->cursor = $cursor;
        }
        else
        {
            $this->cursor = 1;
        }

        $this->base_url .= $request->base_url . '/' . $request->controller . '/' . $request->method . '/'; // TODO: imploded params

        $this->buttons = array();

        $this->buttons['first']            = array();
        $this->buttons['first']['text']    = '&#8810;';
        $this->buttons['first']['enabled'] = TRUE;

        $this->buttons['previous']            = array();
        $this->buttons['previous']['text']    = '&lt;';
        $this->buttons['previous']['enabled'] = TRUE;

        $this->buttons['next']            = array();
        $this->buttons['next']['text']    = '&gt;';
        $this->buttons['next']['enabled'] = TRUE;

        $this->buttons['last']            = array();
        $this->buttons['last']['text']    = '&#8811;';
        $this->buttons['last']['enabled'] = TRUE;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->cursor);
        unset($this->base_url);
        unset($this->total);

        unset($this->per_page);
        unset($this->range);
        unset($this->pages_total);

        unset($this->buttons);
    }

    /**
     * Define the total number of items to be paginated.
     *
     * @param Integer $nritems the actual number of items
     *
     * @return Pagination $self self reference
     */
    public function set_total_items($nritems)
    {
        if (is_int($nritems) && $nritems > 0)
        {
            $this->total = $nritems;
        }
        return $this;
    }

    /**
     * Define the base url of the pagination links.
     *
     * @param String $url the actual base url
     *
     * @return Pagination $self self reference
     */
    public function set_base_url($url)
    {
        if (isset($url) && is_string($url))
        {
            $this->base_url = $url;
        }
        return $this;
    }

    /**
     * Assign labels to the first, last, next & previous buttons.
     *
     * @param String $key   can be one of the following:
     *                      'first', 'last', 'next', 'previous'
     * @param String $label the text to be put at the corresponding button
     *
     * @return Pagination $self self reference
     */
    public function set_button_label($key, $label='')
    {
        if (array_key_exists($key, $this->buttons))
        {
            $this->buttons[$key]['text'] = $label;
        }
        return $this;
    }

    /**
     * Define the number of pages displayed before and after the current one.
     *
     * @param Integer $range the actual range
     *
     * @return Pagination $self self reference
     */
    public function set_range($range)
    {
        if (is_int($range) && $range > 0)
        {
            $this->range = $range;
        }
        return $this;
    }

    /**
     * Define the number of items per page.
     *
     * @param Integer $per_page the actual number of items per page
     *
     * @return Pagination $self self reference
     */
    public function set_items_per_page($per_page)
    {
        if (is_int($per_page) && $per_page > 0)
        {
            $this->per_page = $per_page;
        }
        return $this;
    }

    /**
     * Creates the cursors that will link to previous pages.
     *
     * Also controlling the visibility of first and previous buttons.
     *
     * @param Integer $amount The amount of previous pages
     *
     * @return mixed $html HTML string on success, FALSE on failure
     */
    private function build_previous($amount)
    {
        if ($amount > 0)
        {
            $html = '';
            if (($this->cursor - $amount) > 0)
            {
                $start = $this->cursor - $amount;
            }
            else
            {
                $start = 1;
            }

            $end = $this->cursor - 1;
            for($i = $start; $i <= $end; ++$i)
            {
                $html .= '<a class="lunr_paginator_page" href="';
                $html .= $this->base_url . $i . '">' . $i . "</a>\n";
            }

            return $html;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Creates the cursors that will link to next pages.
     *
     * Also controlling the visibility of last and next buttons
     *
     * @param Integer $amount The amount of next pages
     *
     * @return mixed $html HTML string on success, FALSE on failure
     */
    private function build_next($amount)
    {
        if ($amount > 0)
        {
            $html  = '';
            $start = $this->cursor + 1;
            $end   = $this->cursor + $amount;
            for($i = $start; (($i <= $end) && ($i <= $this->pages_total)); ++$i)
            {
                $html .= '<a class="lunr_paginator_page" href="';
                $html .= $this->base_url . $i . '">' . $i . "</a>\n";
            }

            return $html;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Build a special pagination button.
     *
     * @param String $type ENUM: previous|next|first|last
     *
     * @return mixed $return The html code if we could generate a button,
     *                       FALSE if an invalid type was passed
     */
    private function build_button($type)
    {
        switch ($type)
        {
            case 'previous':
                $target = $this->cursor - 1;
                break;
            case 'next':
                $target = $this->cursor + 1;
                break;
            case 'first':
                $target = 1;
                break;
            case 'last':
                $target = $this->pages_total;
                break;
            default:
                return FALSE;
        }

        if ($this->buttons[$type]['enabled'])
        {
            // these divs wrap the test (or image) for the buttons:
            // first, last, previous and second
            $html  = "<div class='lunr_paginator_$type'><a href='";
            $html .= $this->base_url . $target . "'>";
            $html .= $this->buttons[$type]['text'] . "</a></div>\n";
        }
        else
        {
            // the same as above but to allow the divs being showed as disabled
            $html  = "<div class='lunr_paginator_$type lunr_paginator_${type}_disabled'>";
            $html .= $this->buttons[$type]['text'] . "</div>\n";
        }

        return $html;
    }

    /**
     * Builds the Pagination html using the following template.
     *
     * <ul>
     * <li>[<<]   first button (enabled or disabled)</li>
     * <li>[<]    previous button (shown or hidden)</li>
     * <li>[2][3] previous cursors (number depends on $range)</li>
     * <li>4      current cursor (does not link anywhere)</li>
     * <li>[5][6] next cursors (number depends on $range)</li>
     * <li>[>]    next button (shown or hidden)</li>
     * <li>[>>]   last button (enabled or disabled)</li>
     * </ul>
     *
     * @return String
     */
    public function create_links()
    {
        // If the total number of items is has its default value,
        // then the set_total_items has not been called and the pagination cannot be built
        if($this->total == -1)
        {
            return FALSE;
        }
        //calculate the total number of pages
        $this->pages_total = ceil($this->total / $this->per_page);

        // current cursor above the limit (pages_total) is not allowed
        if ($this->cursor > $this->pages_total)
        {
            $this->cursor = $this->pages_total;
        }

        // If range is bigger than the amount of previous pages, increase
        // the amount of next pages shown
        if ($this->cursor <= $this->range)
        {
            $nprevious = $this->cursor - 1;
            $nnext     = $this->range + $this->range - $nprevious;
        }

        // If range is bigger than the amount of next pages, check whether
        // the amount of previous pages was already defined and if not,
        // increase the amount of previous pages shown
        if ($this->cursor > $this->pages_total - $this->range)
        {
            $nnext = $this->pages_total - $this->cursor;
            if (!isset($nprevious))
            {
                $nprevious = $this->range + $this->range - $nnext;
            }
        }
        else
        {
            if (!isset($nnext))
            {
                $nnext = $this->range;
            }

            if (!isset($nprevious))
            {
                $nprevious = $this->range;
            }
        }

        if ($this->cursor == 1)
        {
            $this->buttons['first']['enabled']    = FALSE;
            $this->buttons['previous']['enabled'] = FALSE;
        }

        if ($this->cursor == $this->pages_total)
        {
            $this->buttons['next']['enabled'] = FALSE;
            $this->buttons['last']['enabled'] = FALSE;
        }

        $html  = $this->build_button('first');
        $html .= $this->build_button('previous');
        // paginator_numbers class div wraps the cursors shown as numbers.
        // This wrapping div allow us to show the numbers centered in screen
        $html .= "<div class='lunr_paginator_numbers'>\n";
        $html .= $this->build_previous($nprevious);
        // using the span we set the style for the current cursor
        $html .= '<span class="lunr_paginator_page lunr_paginator_page_sel">';
        $html .= $this->cursor . "</span>\n";
        $html .= $this->build_next($nnext);
        $html .= "</div>\n"; // closes <div class='lunr_paginator_numbers'>
        $html .= $this->build_button('next');
        $html .= $this->build_button('last');

        return $html;
    }

}

?>
