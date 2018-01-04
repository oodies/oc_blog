<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace User\Infrastructure\Service;

use User\Domain\Model\User;
use User\Infrastructure\Persistence\CQRS\WriteRepository;

/**
 * Class UserStatusService
 * @package User\Infrastructure\Service
 */
class UserStatusService
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
     * Lock user
     *
     * @param User $user
     *
     * @return User
     */
    public function lock(User $user): User
    {
        $user->lock();
        $this->repository->add($user);

        return $user;
    }

    /**
     * Unlock user
     *
     * @param User $user
     *
     * @return User
     */
    public function unlock(User $user): User
    {
        $user->unlock();
        $this->repository->add($user);

        return $user;
    }
}
