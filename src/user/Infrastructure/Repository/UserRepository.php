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

/**
 * Class UserRepository
 * @package User\Infrastructure\Repository
 */
class UserRepository extends AbstractRepository
{
    /** *******************************
     *      PROPERTIES
     * ********************************/

    /** @var string $gatewayName */
    protected $gatewayName = UserTableGateway::class;

    /** *******************************
     *      METHODS
     * ********************************/


    /**
     * Find User by 'UserID'
     *
     * @param UserID $userID
     *
     * @return User
     */
    public function findByUserID(UserID $userID): User
    {
        /** @var User $user */
        $user = new User();

        $row = $this->getDbTable()->findByUserID($userID->getValue());
        if ($row !== false) {
            $user
                ->setIdUser($row['id_user'])
                ->setUserID($userID)
                ->setNickname($row['nickname'])
                ->setFirstname($row['firstname'])
                ->setLastname($row['lastname'])
                ->setUsername($row['username'])
                ->setEmail($row['email'])
                ->setEnabled($row['enabled'])
                ->setSalt($row['salt']);
        }
        return $user;
    }


    /**
     * Find all users
     *
     * @return array User
     */
    public function findAll()
    {
        $rowSet = $this->getDbTable()->findAll();

        $entries = [];
        if (count($rowSet)) {
            foreach ($rowSet as $key => $row) {
                $user = new User();
                $user
                    ->setIdUser($row['id_user'])
                    ->setUserID(new UserID($row['userID']))
                    ->setNickname($row['nickname'])
                    ->setFirstname($row['firstname'])
                    ->setLastname($row['lastname'])
                    ->setUsername($row['username'])
                    ->setEmail($row['email'])
                    ->setEnabled($row['enabled'])
                    ->setSalt($row['salt']);;
                $entries[] = $user;
                unset($user);
            }
        }
        return $entries;
    }

    /**
     * Persist model
     *
     * @param User $user
     *
     * @throws \Exception
     */
    public function save(User $user): void
    {
        $data['userID'] = $user->getUserID()->getValue();
        $data['nickname'] = $user->getNickname();
        $data['firstname'] = $user->getFirstname();
        $data['lastname'] = $user->getLastname();
        $data['username'] = $user->getUsername();
        $data['email'] = $user->getEmail();
        $data['enabled'] = (int)$user->isEnabled();
        $data['salt'] = $user->getSalt();

        if ($user->getIdUser() === null) {
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, $user->getIdUser());
        }
    }
}