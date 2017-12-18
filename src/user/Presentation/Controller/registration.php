<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace User\Presentation\Controller;

use Lib\Controller\Controller;
use User\Domain\Model\User;
use User\Domain\Services\UserService;

/**
 * Class registration
 */
class registration extends Controller
{
    /**
     * Registration user
     *
     */
    public function registerAction()
    {
        $assign = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = (isset($_POST['username'])) ? htmlspecialchars($_POST['username']) : '';
            $nickname = (isset($_POST['nickname'])) ? htmlspecialchars($_POST['nickname']) : '';
            $firstname = (isset($_POST['firstname'])) ? htmlspecialchars($_POST['firstname']) : '';
            $lastname = (isset($_POST['lastname'])) ? htmlspecialchars($_POST['lastname']) : '';
            $email = (isset($_POST['email'])) ? htmlspecialchars($_POST['email']) : '';

            $user = new User();
            $user
                ->setNickname($nickname)
                ->setLastname($lastname)
                ->setFirstname($firstname)
                ->setUsername($username)
                ->setEmail($email);

            // TODO valider les données
            //if ($userAggregate->isValid()) {
            if (true) {
                $userService = new UserService();
                $userService->postUser($user);
            } else {
                $assign = [
                    'username'  => $_POST['username'],
                    'firstname' => $_POST['firstname'],
                    'lastname'  => $_POST['lastname'],
                    'email'     => $_POST['email']
                ];
            }
        }

        echo $this->render('user:registration:register.html.twig', $assign);
    }
}