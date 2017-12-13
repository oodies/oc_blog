<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace User\Domain\Services;

use User\Domain\Model\User;
use User\Domain\ValueObject\UserID;
use User\Infrastructure\Repository\UserRepository;

/**
 * Class UserService
 * @package User\Domain\Services
 */
class UserService
{
    /**
     * Get a simple user
     *
     * @param string $userID
     *
     * @return User
     */
    public function getUser(string $userID)
    {
        $userRepository = new UserRepository();
        $user = $userRepository->findByUserID(new UserID($userID));

        return $user;
    }

    /**
     * Return an users list
     *
     * @return array
     */
    public function getUsers()
    {
        $userRepository = new UserRepository();
        $users = $userRepository->findAll();

        return $users;
    }

    /**
     * Create a new complete user
     *
     * @param User $user
     */
    public function postUser(User $user): void
    {
        $userRepository = new UserRepository();
        $userRepository->save($user);
    }
}