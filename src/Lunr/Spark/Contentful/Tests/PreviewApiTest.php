<?php

/**
 * This file contains the PreviewApiTest class.
 *
 * @package    Lunr\Spark\Contentful
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2015-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Contentful\Tests;

use Lunr\Spark\CentralAuthenticationStore;
use Lunr\Spark\Contentful\PreviewApi;
use Lunr\Halo\LunrBaseTest;
use Psr\Log\LoggerInterface;
use WpOrg\Requests\Response;
use WpOrg\Requests\Session;
use ReflectionClass;

/**
 * This class contains the tests for the PreviewApi.
 *
 * @covers Lunr\Spark\Contentful\PreviewApi
 */
abstract class PreviewApiTest extends LunrBaseTest
{

    /**
     * Mock instance of the CentralAuthenticationStore class.
     * @var CentralAuthenticationStore
     */
    protected $cas;

    /**
     * Mock instance of the Requests\Session class.
     * @var Session
     */
    protected $http;

    /**
     * Mock instance of the Logger class
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the Requests\Response class.
     * @var Response
     */
    protected $response;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->cas      = $this->getMockBuilder('Lunr\Spark\CentralAuthenticationStore')->getMock();
        $this->http     = $this->getMockBuilder('WpOrg\Requests\Session')->getMock();
        $this->logger   = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();
        $this->response = $this->getMockBuilder('WpOrg\Requests\Response')->getMock();

        $this->class = new PreviewApi($this->cas, $this->logger, $this->http);

        $this->reflection = new ReflectionClass('Lunr\Spark\Contentful\PreviewApi');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->cas);
        unset($this->http);
        unset($this->logger);
        unset($this->response);
    }

}

?>
