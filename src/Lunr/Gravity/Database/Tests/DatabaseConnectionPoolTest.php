<?php

/**
 * This file contains the DatabaseConnectionPoolTest class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Gravity\Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseConnectionPool;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * This class contains common constructors/destructors and data providers
 * for testing the DatabaseConnectionPool class.
 *
 * @covers Lunr\Gravity\Database\DatabaseConnectionPool
 */
abstract class DatabaseConnectionPoolTest extends TestCase
{

    /**
     * Instance of the DatabaseConnectionPool class.
     * @var DatabaseConnectionPool
     */
    protected $pool;

    /**
     * Reflection instance of the DatabaseConnectionPool class.
     * @var ReflectionClass
     */
    protected $pool_reflection;

    /**
     * Mock instance of the sub Configuration class.
     * @var Configuration
     */
    protected $sub_configuration;

    /**
     * Mock instance of the Configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function emptySetup()
    {
        $this->sub_configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $map = [
            [ 'db', $this->sub_configuration ],
        ];

        $this->configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->pool = new DatabaseConnectionPool($this->configuration, $this->logger);

        $this->pool_reflection = new ReflectionClass('Lunr\Gravity\Database\DatabaseConnectionPool');
    }

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function unsupportedSetup()
    {
        $this->sub_configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $map = [
            [ 'db', $this->sub_configuration ],
        ];

        $this->configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $map = [
            [ 'rw_host', 'rw_host' ],
            [ 'username', 'username' ],
            [ 'password', 'password' ],
            [ 'database', 'database' ],
            [ 'driver', 'unsupported' ],
        ];

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->pool = new DatabaseConnectionPool($this->configuration, $this->logger);

        $this->pool_reflection = new ReflectionClass('Lunr\Gravity\Database\DatabaseConnectionPool');
    }

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function supportedSetup()
    {
        $this->sub_configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $map = [
            [ 'db', $this->sub_configuration ],
        ];

        $this->configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $map = [
            [ 'rw_host', 'rw_host' ],
            [ 'username', 'username' ],
            [ 'password', 'password' ],
            [ 'database', 'database' ],
            [ 'driver', 'mysql' ],
        ];

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->pool = new DatabaseConnectionPool($this->configuration, $this->logger);

        $this->pool_reflection = new ReflectionClass('Lunr\Gravity\Database\DatabaseConnectionPool');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->pool);
        unset($this->pool_reflection);
        unset($this->configuration);
        unset($this->logger);
    }

}

?>
