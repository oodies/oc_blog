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

/**
 * Class UserService
 */
class UserReadService
{
    /**
     * @var ReadRepository
     */
    protected $repository;


    /**
     * UserService constructor.
     *
     * @param $repository
     */
    public function __construct(ReadRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Get User by UserID (value object)
     *
     * @param UserID $userID
     *
     * @return User
     */
    public function getByUserID(UserID $userID): User
    {
        return $this->repository->getByUserID($userID);
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
        return $this->repository->findByEmail($email);
    }

    /**
     * Find an user by username
     *
     * @param string $email
     *
     * @return null|User
     */
    public function findByUsername(string $username): ?User
    {
        return $this->repository->findByUsername($username);
    }

    /**
     * Get all users
     *
     * @return array User
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }
}
