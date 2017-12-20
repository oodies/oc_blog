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
use User\Infrastructure\Persistence\CQRS\ReadRepository;
use User\Infrastructure\Persistence\CQRS\WriteRepository;
use User\Infrastructure\Repository\ReadDataMapperRepository;
use User\Infrastructure\Repository\WriteDataMapperRepository;
use User\Infrastructure\Service\UserReadService;
use User\Infrastructure\Service\UserRegisterService;

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $post = Registry::get('request')->getParsedBody();

            $password = $post['password'];
            foreach ($post as $key => $value) {
                $data[$key] = htmlspecialchars($value);
            }

            $userRegisterService = new UserRegisterService(
                new WriteRepository(
                    new WriteDataMapperRepository()
                ));

            $user = $userRegisterService->create($data);

            // TODO parade car je n'ai pas le id_user en retour du service "create"
            $userReadService = new UserReadService(
                new ReadRepository(
                    new ReadDataMapperRepository()
                ));
            $user = $userReadService->getByUserID($user->getUserID());

            // Save password
            $userRegisterService->register($user, $password);
        }

        echo $this->render('user:registration:register.html.twig', []);
    }
}