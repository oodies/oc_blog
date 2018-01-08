<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/01
 */

namespace App\Infrastructure\Service;

use Swift_Mailer;
use Swift_Message;
use App\Domain\Model\Mail;

/**
 * Class MailService
 *
 * @package App\Infrastructure\Service
 */
class MailService
{
    /**
     * Send a mail
     *
     * @param Mail $mail
     */
    public function send(Mail $mail)
    {
        if (is_null($mail->getTo())) {
            $mail->setTo($this->getConfig()['mailer_delivery_addresses']);
        }

        if (is_null($mail->getFrom())) {
            $mail->setFrom(
                [
                    $this->getConfig()['mailer_sender_email'] => $this->getConfig()['mailer_sender_name'],
                ]
            );
        }

        $message = (new Swift_Message($mail->getSubject()))
            ->setFrom($mail->getFrom())
            ->setTo($mail->getTo())
            ->setBody($mail->getBody());

        $this->getMailer()->send($message);
    }

    /**
     * Get custom parameters configuration to send mail
     *
     * @return array
     * @throws \Exception
     *
     */
    private function getConfig()
    {
        $config = \parse_ini_file(ROOT_DIR . '/configs/application.ini', true);

        if (false === $config) {
            throw new \Exception('Error while reading configuration parameters');
        }

        return $config['MAILER'];
    }

    /**
     * Return a Swift_Mailer with its configuration
     *
     * @return Swift_Mailer
     * @throws \Exception
     */
    private function getMailer(): Swift_Mailer
    {
        $config = $this->getConfig();

        $transport = (new \Swift_SmtpTransport($config['mailer_host'], $config['mailer_port']))
            ->setUsername($config['mailer_user'])
            ->setPassword($config['mailer_password']);

        return new Swift_Mailer($transport);
    }
}
