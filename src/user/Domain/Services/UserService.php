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
    /** *******************************
     *      PROPERTIES
     */

    /** @var UserRepository */
    protected $userRepository;

    /** *******************************
     *      METHODS
     */

    /**
     * UserService Constructor
     */
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * Get a simple user
     *
     * @param string $userID
     *
     * @return User
     */
    public function getUser(string $userID)
    {
        return $this->userRepository->findByUserID(new UserID($userID));
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function getUserByEmail(string $email)
    {
        return $this->userRepository->findByEmail($email);
    }

    /**
     * Return an users list
     *
     * @return array
     */
    public function getUsers()
    {
        return $this->userRepository->findAll();
    }

    /**
     * Create a new complete user
     *
     * @param User $user
     *
     * @throws \Exception
     *
     * @return void
     */
    public function postUser(User $user): void
    {
        $this->userRepository->save($user);
    }
}