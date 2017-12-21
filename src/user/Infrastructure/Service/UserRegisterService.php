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
use User\Infrastructure\Password\Encoder;
use User\Infrastructure\Persistence\CQRS\WriteRepository;

/**
 * Class UserRegisterService
 * @package User\Infrastructure\Service
 */
class UserRegisterService
{
    /**
     * @var WriteRepository
     */
    protected $repository;


    /**
     * UserRegisterService constructor.
     *
     * @param WriteRepository $repository
     * @param                 $userEntity
     */
    public function __construct(WriteRepository $repository)
    {
        $this->repository = $repository;
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
        $user = new User(new UserID());
        $user->createUser($username, $email);
        $this->repository->add($user);

        return $user;
    }

    /**
     * @param User $user
     * @param      $password
     *
     * @return User
     */
    public function register(User $user, $password): User
    {
        $hash = Encoder::encode($password);

        $user->setPassword($hash);
        $this->repository->add($user);

        return $user;
    }
}