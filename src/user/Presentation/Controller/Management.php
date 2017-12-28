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
use User\Domain\ValueObject\UserID;
use User\Infrastructure\Persistence\CQRS\ReadRepository;
use User\Infrastructure\Persistence\CQRS\WriteRepository;
use User\Infrastructure\Repository\ReadDataMapperRepository;
use User\Infrastructure\Repository\WriteDataMapperRepository;
use User\Infrastructure\Service\UserReadService;
use User\Infrastructure\Service\UserStatusService;
use User\Infrastructure\Service\UserWriteService;

/**
 * Class Management
 * @package User\Presentation\Controller
 */
class Management extends Controller
{
    /**
     * Return a profile user
     *
     * @throws \Exception
     *
     */
    public function getUserAction()
    {
        $params = Registry::get('request')->getQueryParams();
        $userID = $params['id'];

        $userReadService = new UserReadService(
            new ReadRepository(
                new ReadDataMapperRepository())
        );

        $user = $userReadService->getByUserID(new UserID($userID));

        echo $this->render('user:management:user.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * Return a users list
     *
     */
    public function getUsersAction()
    {
        $userReadService = new UserReadService(
            new ReadRepository(
                new ReadDataMapperRepository())
        );

        $users = $userReadService->findAll();

        echo $this->render('user:management:userList.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * Complete change of user data
     *
     * @throws \Exception
     */
    public function putUserAction()
    {
        $params = Registry::get('request')->getQueryParams();
        $userID = $params['id'];

        $userReadService = new UserReadService(
            new ReadRepository(
                new ReadDataMapperRepository())
        );
        $user = $userReadService->getByUserID(new UserID($userID));
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $post = Registry::get('request')->getParsedBody();

            foreach ($post as $key => $value) {
                $data[$key] = htmlspecialchars($value);
            }

            $userWriteService = new UserWriteService (
                new WriteRepository(new WriteDataMapperRepository())
            );
            $userWriteService->update($user, $data);
        }

        echo $this->render('user:management:changeUser.html.twig', ['user' => $user]);
    }

    /**
     * Create a User by admin interface
     *
     * @throws \Exception
     */
    public function postUserAction()
    {
        $user = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $post = Registry::get('request')->getParsedBody();
            foreach ($post as $key => $value) {
                $data[$key] = htmlspecialchars($value);
            }

            $userWriteService = new UserWriteService(
                new WriteRepository(new WriteDataMapperRepository())
            );
            $user = $userWriteService->createUser(
                $data['username'],
                $data['email'],
                $data['firstname'],
                $data['lastname'],
                $data['nickname']);
        }

        echo $this->render('user:management:newUser.html.twig', ['user' => $user]);
    }

    /**
     * Lock a user
     *
     * @throws \Exception
     */
    public function lockAction()
    {
        $params = Registry::get('request')->getQueryParams();
        $userID = $params['id'];

        $userReadService = new UserReadService(
            new ReadRepository(
                new ReadDataMapperRepository())
        );
        $user = $userReadService->getByUserID(new UserID($userID));

        $userStatusService = new UserStatusService(
            new WriteRepository(
                new WriteDataMapperRepository()
            ));

        $userStatusService->lock($user);
    }

    /**
     * Unlock a user
     *
     * @throws \Exception
     */
    public function unlockAction()
    {
        $params = Registry::get('request')->getQueryParams();
        $userID = $params['id'];

        $userReadService = new UserReadService(
            new ReadRepository(
                new ReadDataMapperRepository())
        );
        $user = $userReadService->getByUserID(new UserID($userID));

        $userStatusService = new UserStatusService(
            new WriteRepository(
                new WriteDataMapperRepository()
            ));

        $userStatusService->unlock($user);
    }
}