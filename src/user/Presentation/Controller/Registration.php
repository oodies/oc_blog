<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace User\Presentation\Controller;

use Lib\Controller\Controller;
use Lib\CsrfToken;
use Lib\HTTPFoundation\HTTPResponse;
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
        $csrfToken = new CsrfToken();

        if ($request->getMethod() === 'POST') {
            $post = $request->getParsedBody();

            if ($csrfToken->validateToken($post['_csrf_token']) === false ) {
                HTTPResponse::redirect403();
            }

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
                // Redirect To Login
                $this->redirectTo($this->generateUrl('user_security_login'));
            } else {
                $assign['email'] = $email;
                $assign['username'] = $username;
                $assign['password'] = $password;
                $assign['errors'] = $constraintViolationList->getViolations();
            }
        }

        $assign['_csrf_token'] = $csrfToken->generateToken();

        echo $this->render('user:registration:register.html.twig', $assign);
    }
}
