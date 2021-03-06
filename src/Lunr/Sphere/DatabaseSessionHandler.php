<?php

/**
 * This file contains the implementation of an alternative
 * session handler for PHP, using the database instead of
 * the local filesystem for session storage.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Sphere
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Sphere;

use SessionHandlerInterface;

/**
 * Database Session Handler Interface implementation
 */
class DatabaseSessionHandler implements SessionHandlerInterface
{

    /**
     * Lifetime of a session instance
     * @var Integer
     */
    private $lifetime;

    /**
     * Instance of SessionDAO
     * @var SessionDAO
     */
    private $sdao;

    /**
     * Constructor.
     *
     * @param SessionDAO $session_dao Session Database Access Object
     */
    public function __construct($session_dao)
    {
        $this->lifetime = ini_get('session.gc_maxlifetime');
        $this->sdao     = $session_dao;
    }

    /**
     * Destructor.
     *
     * @return void
     */
    public function __destruct()
    {
        unset($this->sdao);
        unset($this->lifetime);
    }

    /**
     * Prepare for session usage.
     *
     * Since we use a database to store the data, we
     * don't really need to do anything here.
     *
     * @param string $path Path to store the session file
     * @param string $name Session name
     *
     * @return boolean $return Returns always true
     */
    public function open($path, $name)
    {
        return TRUE;
    }

    /**
     * Close access to session file.
     *
     * Sine we do not use file for session dara storage
     * we don't need to do anything here.
     *
     * @return boolean $return Returns always true
     */
    public function close()
    {
        return TRUE;
    }

    /**
     * Read session data from the database.
     *
     * @param string $id Session ID
     *
     * @return mixed $return Session data on success, False on failure
     */
    public function read($id)
    {
        return $this->sdao->read_session_data($id);
    }

    /**
     * Save session data into the database.
     *
     * @param string $id   Session ID
     * @param string $data Session Data
     *
     * @return boolean $return Returns always true
     */
    public function write($id, $data)
    {
        $this->sdao->write_session_data($id, $data, time() + $this->lifetime);
        return TRUE;
    }

    /**
     * End currently active session.
     *
     * @param string $id Session ID
     *
     * @return boolean $return Returns always true
     */
    public function destroy($id)
    {
        $this->sdao->delete_session($id);
        return TRUE;
    }

    /**
     * Clean up expired sessions.
     *
     * @param integer $maxlifetime Sessions that have not updated for the last maxlifetime seconds will be removed.
     *
     * @return boolean $return Returns always true
     */
    public function gc($maxlifetime)
    {
        $this->sdao->session_gc($maxlifetime);
        return TRUE;
    }

}

?>
