<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace User\Domain\Repository;

use User\Domain\ValueObject\UserID;
use User\Domain\Model\User;

/**
 * Interface ReadRepositoryInterface
 * @package User\Domain\Repository
 */
interface ReadRepositoryInterface
{
    /**
     * Find a user by email
     *
     * @param string $email
     *
     * @return null|User
     */
    public function findByEmail(string $email): ?User;

    /**
     * Find a user by username
     *
     * @param string $username
     *
     * @return null|mixed
     */
    public function findByUsername(string $username): ?User;

    /**
     * Find all users
     *
     * @return array User
     */
    public function findAll(): array;

    /**
     * Get a user by UserID value object
     *
     * @param UserID $userID
     *
     * @return User
     */
    public function getByUserID(UserID $userID): User;
}
