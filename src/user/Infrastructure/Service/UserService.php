<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace User\Infrastructure\Service;

use User\Domain\Model\User;
use User\Domain\ValueObject\UserID;
use User\Infrastructure\Persistence\CQRS\ReadRepository;
use User\Infrastructure\Persistence\CQRS\WriteRepository;
use User\Infrastructure\Repository\ReadDataMapperRepository;
use User\Infrastructure\Repository\WriteDataMapperRepository;


/**
 * Class UserService
 * @package User\Infrastructure\Service
 */
class UserService
{
    /**
     * Get User by UserID
     *
     * @param string $userID
     *
     * @return null|User
     */
    public function getByUserID(string $userID): ?User
    {
        $userReadService = new UserReadService(
            new ReadRepository(
                new ReadDataMapperRepository()
            ));
        $user = $userReadService->getByUserID(new UserID($userID));

        return $user;
    }

    /**
     * Find an user by email
     *
     * @param string $email
     *
     * @return null|User
     */
    public function findByEmail(string $email): ?User
    {
        $userReadService = new UserReadService(
            new ReadRepository(
                new ReadDataMapperRepository()
            ));
        $user = $userReadService->findByEmail($email);

        return $user;
    }

    /**
     * Create a new user
     *
     * @param string $username
     * @param string $email
     *
     * @return User
     */
    public function create(string $username, string $email): User
    {
        $userRegisterService = new UserRegisterService(
            new WriteRepository(
                new WriteDataMapperRepository()
            )
        );
        return $userRegisterService->create($username, $email);
    }
}
