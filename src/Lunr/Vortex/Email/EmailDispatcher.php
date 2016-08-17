<?php

/**
 * This file contains functionality to dispatch Email Notifications.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email;

use Lunr\Vortex\PushNotificationDispatcherInterface;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

/**
 * Email Notification Dispatcher.
 */
class EmailDispatcher implements PushNotificationDispatcherInterface
{
    /**
     * Email Notification source.
     * @var String
     */
    private $source;

    /**
     * Email Notification endpoint.
     * @var String
     */
    private $endpoint;

    /**
     * Email Notification payload to send.
     * @var String
     */
    private $payload;

    /**
     * Shared instance of the Mail class.
     * @var \PHPMailer\PHPMailer\PHPMailer
     */
    private $mail;

    /**
     * Shared instance of a Logger class.
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Constructor.
     *
     * @param \PHPMailer\PHPMailer\PHPMailer $mail   Shared instance of the PHPMailer class.
     * @param \Psr\Log\LoggerInterface       $logger Shared instance of a Logger.
     */
    public function __construct($mail, $logger)
    {
        $this->source   = '';
        $this->endpoint = '';
        $this->payload  = '';
        $this->mail     = $mail;
        $this->logger   = $logger;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->source);
        unset($this->endpoint);
        unset($this->payload);
        unset($this->mail);
        unset($this->logger);
    }

    /**
     * Get a cloned instance of the mail transport class.
     *
     * @return \PHPMailer\PHPMailer\PHPMailer $mail Cloned instance of the PHPMailer class
     */
    private function clone_mail()
    {
        return clone $this->mail;
    }

    /**
     * Send the notification.
     *
     * @return EmailResponse $return Response object
     */
    public function push()
    {
        $mail = $this->clone_mail();

        try
        {
            $mail->setFrom($this->source);
            $mail->addAddress($this->endpoint);

            $payload_array = json_decode($this->payload, TRUE);

            $mail->Subject = $payload_array['subject'];
            $mail->Body = $payload_array['body'];

            $mail->send();

            $res = new EmailResponse($mail, $this->logger, $this->endpoint);
        }
        catch (PHPMailerException $e)
        {
            $res = new EmailResponse($mail, $this->logger, $this->endpoint);
        }

        $this->endpoint = '';
        $this->payload  = '';

        return $res;
    }

    /**
     * Set the source for the email.
     *
     * @param String $source The endpoint for the email
     *
     * @return EmailDispatcher $self Self reference
     */
    public function set_source($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Set the endpoints for the email.
     *
     * @param Array|String $endpoints The endpoint for the email
     *
     * @return EmailDispatcher $self Self reference
     */
    public function set_endpoints($endpoints)
    {
        if (is_array($endpoints))
        {
            $this->endpoint = empty($endpoints) ? '' : $endpoints[0];
        }
        else
        {
            $this->endpoint = $endpoints;
        }

        return $this;
    }

    /**
     * Set the the payload to email.
     *
     * @param String $payload The reference to the payload of the email
     *
     * @return EmailDispatcher $self Self reference
     */
    public function set_payload(&$payload)
    {
        $this->payload =& $payload;

        return $this;
    }

}

?>
