<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace User\Infrastructure\Repository;

use Lib\Db\AbstractRepository;
use User\Domain\Model\User;
use User\Domain\ValueObject\UserID;
use User\Infrastructure\Repository\TableGateway\UserTableGateway;
use User\Domain\Repository\ReadRepositoryInterface;

/**
 * Class ReadDataMapperRepository
 *
 * @package User\Infrastructure\Repository
 */
class ReadDataMapperRepository extends AbstractRepository implements ReadRepositoryInterface
{
    /** *******************************
     *      PROPERTIES
     **/

    /** @var string $gatewayName */
    protected $gatewayName = UserTableGateway::class;

    /** *******************************
     *      METHODS
     **/

    /**
     * Find user by email
     *
     * @param string $email
     *
     * @return null|User
     */
    public function findByEmail(string $email): ?User
    {
        $row = $this->getDbTable()->findByEmail($email);

        if ($row == false) {
            return null;
        }

        /** @var User $user */
        $user = new User();
        $this->hydrate($user, $row);

        return $user;
    }

    /**
     * Find a user by username
     *
     * @param string $username
     *
     * @return null|User
     */
    public function findByUsername(string $username): ?User
    {
        $row = $this->getDbTable()->findByUsername($username);

        if ($row == false) {
            return null;
        }

        /** @var User $user */
        $user = new User();
        $this->hydrate($user, $row);

        return $user;
    }

    /**
     * Find all users
     *
     * @return array User
     */
    public function findAll(): array
    {
        $entries = [];

        $rowSet = $this->getDbTable()->findAll();
        if (count($rowSet)) {
            foreach ($rowSet as $row) {
                $user = new User();
                $this->hydrate($user, $row);
                $entries[] = $user;
                unset($user);
            }
        }

        return $entries;
    }

    /**
     * Get a user by UserID value object
     *
     * @param UserID $userID
     *
     * @return null|User
     */
    public function getByUserID(UserID $userID): ?User
    {
        $row = $this->getDbTable()->findByUserID($userID->getValue());

        if ($row == false) {
            return null;
        }

        /** @var User $user */
        $user = new User();
        $this->hydrate($user, $row);

        return $user;
    }

    /**
     * @return UserTableGateway
     */
    protected function getDbTable(): UserTableGateway
    {
        return parent::getDbTable();
    }

    /**
     * @param User  $user
     * @param array $row
     */
    protected function hydrate(User $user, array $row)
    {
        $user
            ->setIdUser($row['id_user'])
            ->setUserID(new UserID($row['userID']))
            ->setNickname($row['nickname'])
            ->setFirstname($row['firstname'])
            ->setLastname($row['lastname'])
            ->setUsername($row['username'])
            ->setEmail($row['email'])
            ->setPassword($row['password'])
            ->setPlainPassword($row['plain_password'])
            ->setEnabled($row['enabled'])
            ->setSalt($row['salt'])
            ->setRegisteredAt(new \dateTime($row['registered_at']))
            ->setUpdateAt(new \DateTime($row['update_at']))
            ->setLocked((bool)$row['locked'])
            ->setRole($row['role']);
    }
}
