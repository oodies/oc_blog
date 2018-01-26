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
use Lib\Validator\ConstraintViolationList;
use User\Domain\Model\User;
use User\Domain\ValueObject\UserID;
use User\Infrastructure\Persistence\CQRS\ReadRepository;
use User\Infrastructure\Persistence\CQRS\WriteRepository;
use User\Infrastructure\Repository\ReadDataMapperRepository;
use User\Infrastructure\Repository\WriteDataMapperRepository;
use User\Infrastructure\Service\ConstraintValidator;
use User\Infrastructure\Service\UserReadService;
use User\Infrastructure\Service\UserRegisterService;
use User\Infrastructure\Service\UserStatusService;
use User\Infrastructure\Service\UserWriteService;

/**
 * Class Management
 *
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
                new ReadDataMapperRepository()
            )
        );

        $user = $userReadService->getByUserID(new UserID($userID));

        echo $this->render(
            'user:management:user.html.twig', [
                                                'user' => $user,
                                            ]
        );
    }

    /**
     * Return a users list
     *
     */
    public function getUsersAction()
    {
        $userReadService = new UserReadService(
            new ReadRepository(
                new ReadDataMapperRepository()
            )
        );

        $users = $userReadService->findAll();

        echo $this->render(
            'user:management:userList.html.twig', [
                                                    'users' => $users,
                                                ]
        );
    }

    /**
     * Complete change of user data
     *
     * @throws \Exception
     */
    public function putUserAction()
    {
        $request = Registry::get('request');

        $params = $request->getQueryParams();
        $userID = $params['id'];

        $userReadService = new UserReadService(
            new ReadRepository(
                new ReadDataMapperRepository()
            )
        );

        $assign = [];
        $user = $userReadService->getByUserID(new UserID($userID));

        if ($request->getMethod() === 'POST') {
            $post = $request->getParsedBody();
            $data = [
                'username'  => $post['username'] ?? '',
                'email'     => $post['email'] ?? '',
                'firstname' => $post['firstname'] ?? '',
                'lastname'  => $post['lastname'] ?? '',
                'nickname'  => $post['nickname'] ?? '',
                'role'      => $post['role'] ?? '',
            ];

            $user->setUsername($data['username'])
                 ->setEmail($data['email'])
                 ->setFirstname($data['firstname'])
                 ->setLastname($data['lastname'])
                 ->setNickname($data['nickname'])
                 ->setRole($data['role']);

            $constraintViolationList = new ConstraintViolationList();
            $isValid = ConstraintValidator::validateRegisterData(
                $data,
                $constraintViolationList
            );

            if ($isValid === true) {
                $userWriteService = new UserWriteService (
                    new WriteRepository(new WriteDataMapperRepository())
                );
                $userWriteService->update($user, $data);
                $this->redirectToAdminUsers();
            } else {
                $assign['errors'] = ['user' => $constraintViolationList->getViolations()];
            }
        }
        $assign['user'] = $user;

        echo $this->render('user:management:changeUser.html.twig', $assign);
    }

    /**
     * Redirect to admin users page
     */
    protected function redirectToAdminUsers()
    {
        // Redirect to /admin/users
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/admin/users");
    }

    /**
     * Create a User by admin interface
     *
     * @throws \Exception
     */
    public function postUserAction()
    {
        $request = Registry::get('request');

        $assign = [];
        $assign['user'] = new User();

        if ($request->getMethod() === 'POST') {
            // Prepare data
            $post = $request->getParsedBody();
            $data = [
                'username'  => $post['username'] ?? '',
                'password'  => $post['password'] ?? '',
                'email'     => $post['email'] ?? '',
                'firstname' => $post['firstname'] ?? '',
                'lastname'  => $post['lastname'] ?? '',
                'nickname'  => $post['nickname'] ?? '',
                'role'      => $post['role'] ?? '',
            ];

            $constraintViolationList = new ConstraintViolationList();
            $isValid = ConstraintValidator::validateRegisterData(
                $data,
                $constraintViolationList
            );

            if ($isValid === true) {
                // Step-1 : Create user
                $userWriteService = new UserWriteService(
                    new WriteRepository(new WriteDataMapperRepository())
                );
                $user = $userWriteService->createUser(
                    $data['username'],
                    $data['email'],
                    $data['firstname'],
                    $data['lastname'],
                    $data['nickname'],
                    $data['role']
                );

                // Step-2 : Get the new user
                $userReadService = new UserReadService(
                    new ReadRepository(
                        new ReadDataMapperRepository()
                    )
                );
                $user = $userReadService->getByUserID($user->getUserID());

                // Step-3 : Persist password
                $userRegisterService = new UserRegisterService(
                    new WriteRepository(
                        new WriteDataMapperRepository()
                    )
                );
                $userRegisterService->register($user, $data['password']);

                // Finally Redirect
                $this->redirectToAdminUsers();
            } else {
                $assign = array_merge(
                    $assign,
                    ['errors' => ['user' => $constraintViolationList->getViolations()]]
                );
            }
        }

        echo $this->render('user:management:newUser.html.twig', $assign);
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
                new ReadDataMapperRepository()
            )
        );
        $user = $userReadService->getByUserID(new UserID($userID));

        $userStatusService = new UserStatusService(
            new WriteRepository(
                new WriteDataMapperRepository()
            )
        );

        $userStatusService->lock($user);

        $this->redirectToAdminUsers();
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
                new ReadDataMapperRepository()
            )
        );
        $user = $userReadService->getByUserID(new UserID($userID));

        $userStatusService = new UserStatusService(
            new WriteRepository(
                new WriteDataMapperRepository()
            )
        );

        $userStatusService->unlock($user);

        $this->redirectToAdminUsers();
    }
}
