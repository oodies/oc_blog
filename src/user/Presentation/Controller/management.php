<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace User\Presentation\Controller;

use Lib\Controller\Controller;
use Lib\Registry;
use User\Domain\Model\User;
use User\Domain\Services\UserService;
use User\Domain\ValueObject\UserID;
use User\Infrastructure\Repository\UserRepository;

/**
 * Class management
 * @package User\Presentation\Controller
 */
class management extends Controller
{
    /**
     * Return a users list
     *
     */
    public function getUsersAction()
    {
        $userService = new UserService();
        $users = $userService->getUsers();

        echo $this->render('user:management:userList.html.twig', array(
            'users' => $users
        ));
    }

    /**
     * Complete change of user data
     *
     */
    public function putUserAction()
    {
        $params = Registry::get('request')->getQueryParams();
        $userID = $params['id'];

        $userRepository = new UserRepository();
        /** @var User $user */
        $user = $userRepository->findByUserID(new UserID($userID));

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = (isset($_POST['username'])) ? $_POST['username'] : '';
            $nickname = (isset($_POST['nickname'])) ? $_POST['nickname'] : '';
            $firstname = (isset($_POST['firstname'])) ? $_POST['firstname'] : '';
            $lastname = (isset($_POST['lastname'])) ? $_POST['lastname'] : '';
            $email = (isset($_POST['email'])) ? $_POST['email'] : '';

            $user->setUsername($username)
                ->setNickname($nickname)
                ->setFirstname($firstname)
                ->setLastname($lastname)
                ->setEmail($email);

            // if ($user->isValid()) {
            if (true) {
                $userRepository->save($user);
            } else {
                // TODO Message d'erreur
            }
        }

        echo $this->render('user:management:changeUser.html.twig', array(
            'user' => $user
        ));
    }
}