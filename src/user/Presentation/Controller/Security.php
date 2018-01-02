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
use User\Infrastructure\Password\Encoder;
use User\Infrastructure\Persistence\CQRS\ReadRepository;
use User\Infrastructure\Repository\ReadDataMapperRepository;
use User\Infrastructure\Service\UserReadService;

/**
 * Class Security
 * @package User\Presentation\Controller
 */
class Security extends Controller
{
    /**
     *
     */
    public function loginAction()
    {
        $request = Registry::get('request');

        if ($request->getMethod() === 'POST') {

            $body = $request->getParsedBody();
            $username = $body['username'];
            $password = $body['password'];

            $userReadService = new UserReadService(
                new ReadRepository(
                    new ReadDataMapperRepository()
                ));

            $user = $userReadService->findByUsername($username);

            $passwordEncoder = new Encoder();
            $isValid = $passwordEncoder->verify($password, $user->getPassword());

            if ($isValid) {
                $this->authenticate($user);

                // TODO - Si authentication valid => Redirection selon le profile
                $host = $_SERVER['HTTP_HOST'];
                $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                header("Location: http://$host$uri");
            }
        }
        echo $this->render('user:security:login.html.twig', []);
    }

    /**
     *
     */
    public function logoutAction()
    {
        // TODO to implement
    }
}