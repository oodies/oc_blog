<?php
/**
 * Created by PhpStorm.
 * User: Sébastien CHOMY
 * Date: 03/12/2017
 * Time: 23:10
 */

namespace App\Presentation\Controller;

use App\Domain\Model\Mail;
use App\Infrastructure\Service\MailService;
use Lib\Controller\Controller;

/**
 * Class ContactUs
 *
 * @package App\Presentation\Controller
 *
 */
class ContactUs extends Controller
{

    /**
     * @throws \Exception
     */
    public function contactUsAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $name = (isset($_POST['name'])) ? strip_tags(htmlspecialchars($_POST['name'])) : '';
            $email = (isset($_POST['email'])) ? strip_tags(htmlspecialchars($_POST['email'])) : '';
            $phone = (isset($_POST['phone'])) ? strip_tags(htmlspecialchars($_POST['phone'])) : '';
            $message = (isset($_POST['message'])) ? strip_tags(htmlspecialchars($_POST['message'])) : '';

            $body = 'You have received a message from ' . $name . "\r\n";
            $body .= 'You can reply to him at his email address ' . $email . "\r\n";
            $body .= 'or phone number ' . $phone . "\r\n";
            $body .= 'its message :' . "\r\n";
            $body .= $message;

            $mail = new Mail();
            $mail->setSubject("Support request " . $name)
                 ->setBody($body);

            $mailService = new MailService();
            $mailService->send($mail);
        }
    }
}
