<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace User\Presentation\Controller;

use Lib\Auth;
use Lib\Controller\Controller;
use Lib\Registry;
use Lib\Validator\ConstraintViolationList;
use User\Infrastructure\Password\Encoder;
use User\Infrastructure\Persistence\CQRS\ReadRepository;
use User\Infrastructure\Repository\ReadDataMapperRepository;
use User\Infrastructure\Service\ConstraintValidator;
use User\Infrastructure\Service\UserReadService;

/**
 * Class Security
 *
 * @package User\Presentation\Controller
 */
class Security extends Controller
{
    /**
     *
     */
    public function loginAction()
    {
        /** @var \GuzzleHttp\Psr7\ServerRequest $request */
        $request = Registry::get('request');

        $assign = [];

        if ($request->getMethod() === 'POST') {
            $post = $request->getParsedBody();
            $username = $post['username'];
            $password = $post['password'];

            $constraintViolationList = new ConstraintViolationList();
            $isValid = ConstraintValidator::validateRegisterData(
                [
                    'username' => $username,
                    'password' => $password,
                ],
                $constraintViolationList
            );

            if ($isValid === true) {
                $userReadService = new UserReadService(
                    new ReadRepository(
                        new ReadDataMapperRepository()
                    )
                );

                $user = $userReadService->findByUsername($username);
                if (!is_null($user)) {
                    $passwordEncoder = new Encoder();
                    $isValidPassword = $passwordEncoder->verify($password, $user->getPassword());

                    if ($isValidPassword) {
                        $auth = Auth::getInstance();
                        $auth->authenticate($user);

                        // TODO - Si authentication valid => Redirection selon le profile
                        $this->redirectTo($this->generateUrl('homepage'));
                    }
                }
                $assign['errors']['authenticate'] = 'Authenticate error !';
            } else {
                $assign['username'] = $username;
                $assign['password'] = $password;
                $assign['errors'] = $constraintViolationList->getViolations();
            }
        }

        echo $this->render('user:security:login.html.twig', $assign);
    }

    /**
     *
     */
    public function logoutAction()
    {
        $this->expireSessionCookie();
        $this->redirectTo($this->generateUrl('homepage'));
    }

    /**
     * Used to destroy session data and session cookie
     */
    protected function expireSessionCookie()
    {
        // Delete all session variables
        $_SESSION = [];

        // Delete cookie session
        if (ini_get('session.use_cookies')) {
            if (isset($_COOKIE[session_name()])) {
                $cookie_params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    false,
                    time() - 42000,
                    $cookie_params['path'],
                    $cookie_params['domain'],
                    $cookie_params['secure'],
                    $cookie_params['httponly']
                );
            }
        }

        // Delete session
        session_destroy();
    }
}
