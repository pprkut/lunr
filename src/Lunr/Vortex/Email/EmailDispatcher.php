<?php

/**
 * This file contains functionality to dispatch Email Notifications.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
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
     * Shared instance of the mail transport class.
     * @var \PHPMailer\PHPMailer\PHPMailer
     */
    private $mail_transport;

    /**
     * Shared instance of a Logger class.
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Constructor.
     *
     * @param \PHPMailer\PHPMailer\PHPMailer $mail_transport Shared instance of the mail transport class.
     * @param \Psr\Log\LoggerInterface       $logger         Shared instance of a Logger.
     */
    public function __construct($mail_transport, $logger)
    {
        $this->source   = '';
        $this->logger   = $logger;

        $this->mail_transport = $mail_transport;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->source);
        unset($this->mail_transport);
        unset($this->logger);
    }

    /**
     * Get a cloned instance of the mail transport class.
     *
     * @return \PHPMailer\PHPMailer\PHPMailer $mail_transport Cloned instance of the PHPMailer class
     */
    private function clone_mail()
    {
        return clone $this->mail_transport;
    }

    /**
     * Send the notification.
     *
     * @param EmailPayload $payload   Payload object
     * @param array        $endpoints Endpoints to send to in this batch
     *
     * @return EmailResponse $return Response object
     */
    public function push($payload, &$endpoints)
    {
        // PHPMailer is not reentrant, so we have to clone it before we can do endpoint specific configuration.
        $mail_transport = $this->clone_mail();

        try
        {
            $mail_transport->setFrom($this->source);
            $mail_transport->addAddress($endpoints[0]);

            $payload_array = json_decode($payload->get_payload(), TRUE);

            $mail_transport->Subject = $payload_array['subject'];
            $mail_transport->Body    = $payload_array['body'];

            $mail_transport->send();

            $res = new EmailResponse($mail_transport, $this->logger, $endpoints[0]);
        }
        catch (PHPMailerException $e)
        {
            $res = new EmailResponse($mail_transport, $this->logger, $endpoints[0]);
        }

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

}

?>
