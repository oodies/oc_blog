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
use User\Infrastructure\Repository\ReadDataMapperRepository;

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
     * @return \User\Domain\Model\User
     */
    public function getByUserID(string $userID): User
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
}
