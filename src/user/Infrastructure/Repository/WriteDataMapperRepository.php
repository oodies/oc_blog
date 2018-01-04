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
use User\Infrastructure\Repository\TableGateway\UserTableGateway;
use User\Domain\Repository\WriteRepositoryInterface;

/**
 * Class WriteDataMapperRepository
 * @package User\Infrastructure\Repository
 */
class WriteDataMapperRepository extends AbstractRepository implements WriteRepositoryInterface
{
    /** *******************************
     *      PROPERTIES
     */

    /** @var string $gatewayName */
    protected $gatewayName = UserTableGateway::class;

    /** *******************************
     *      METHODS
     */

    /**
     * @param \User\Domain\Model\User $user
     *
     * @throws \Exception
     */
    public function add(User $user): void
    {
        $data = [
            'userID'         => $user->getUserID()->getValue(),
            'nickname'       => $user->getNickname(),
            'firstname'      => $user->getFirstname(),
            'lastname'       => $user->getLastname(),
            'username'       => $user->getUsername(),
            'email'          => $user->getEmail(),
            'enabled'        => (int)$user->isEnabled(),
            'salt'           => $user->getSalt(),
            'password'       => $user->getPassword(),
            'plain_password' => $user->getPlainPassword(),
            'registered_at'  => $user->getRegisteredAt()->format('Y-m-d H:i:s'),
            'update_at'      => $user->getUpdateAt()->format('Y-m-d H:i:s'),
            'locked'         => (int)$user->getLocked(),
            'role'           => $user->getRole()
        ];

        if ($user->getIdUser() === null) {
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, $user->getIdUser());
        }
    }

    /**
     * @return UserTableGateway
     */
    protected function getDbTable(): UserTableGateway
    {
        return parent::getDbTable();
    }
}
