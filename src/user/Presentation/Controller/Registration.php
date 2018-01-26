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
use User\Infrastructure\Persistence\CQRS\ReadRepository;
use User\Infrastructure\Persistence\CQRS\WriteRepository;
use User\Infrastructure\Repository\ReadDataMapperRepository;
use User\Infrastructure\Repository\WriteDataMapperRepository;
use User\Infrastructure\Service\ConstraintValidator;
use User\Infrastructure\Service\UserReadService;
use User\Infrastructure\Service\UserRegisterService;

/**
 * Class Registration
 */
class Registration extends Controller
{
    /**
     * Registration user
     *
     */
    public function registerAction()
    {
        /** @var \GuzzleHttp\Psr7\ServerRequest $request */
        $request = Registry::get('request');

        $assign = [];

        if ($request->getMethod() === 'POST') {
            $post = $request->getParsedBody();
            $email = $post['email'];
            $username = $post['username'];
            $password = $post['password'];

            $constraintViolationList = new ConstraintViolationList();
            $isValid = ConstraintValidator::validateRegisterData(
                [
                    'email'    => $email,
                    'username' => $username,
                    'password' => $password,
                ],
                $constraintViolationList
            );

            if ($isValid === true) {
                $userRegisterService = new UserRegisterService(
                    new WriteRepository(
                        new WriteDataMapperRepository()
                    )
                );
                $user = $userRegisterService->create($username, $email);

                // TODO parade car je n'ai pas le id_user en retour du service "create"
                $userReadService = new UserReadService(
                    new ReadRepository(
                        new ReadDataMapperRepository()
                    )
                );
                $user = $userReadService->getByUserID($user->getUserID());

                // Save password
                $userRegisterService->register($user, $password);

                $host = $_SERVER['HTTP_HOST'];
                $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                header("Location: http://$host$uri/login");

            } else {
                $assign['email'] = $email;
                $assign['username'] = $username;
                $assign['password'] = $password;
                $assign['errors'] = $constraintViolationList->getViolations();
            }
        }

        echo $this->render('user:registration:register.html.twig', $assign);
    }
}
