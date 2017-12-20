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
 * Class UserWriteService
 * @package User\Infrastructure\Service
 */
class UserWriteService
{
    /**
     * @var WriteRepository
     */
    protected $repository;


    /**
     * UserWriteService constructor.
     *
     * @param WriteRepository $repository
     */
    public function __construct(WriteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Update a user with data
     *
     * @param User  $user
     * @param array $data
     *
     * @return User
     */
    public function update(User $user, array $data)
    {
        if (isset($data['nickname'])) {
            $user->setNickname($data['nickname']);
        }
        if (isset($data['firstname'])) {
            $user->setFirstname($data['firstname']);
        }
        if (isset($data['lastname'])) {
            $user->setLastname($data['lastname']);
        }
        if (isset($data['username'])) {
            $user->setUsername($data['username']);
        }
        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }

        $user->updateUser($user);
        $this->repository->add($user);

        return $user;
    }
}