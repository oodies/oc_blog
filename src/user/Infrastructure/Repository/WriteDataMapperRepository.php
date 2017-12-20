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
     * ********************************/

    /** @var string $gatewayName */
    protected $gatewayName = UserTableGateway::class;

    /** *******************************
     *      METHODS
     * ********************************/

    /**
     * @param \User\Domain\Model\User $user
     *
     * @throws \Exception
     */
    public function add(User $user): void
    {
        $data['userID'] = $user->getUserID()->getValue();
        $data['nickname'] = $user->getNickname();
        $data['firstname'] = $user->getFirstname();
        $data['lastname'] = $user->getLastname();
        $data['username'] = $user->getUsername();
        $data['email'] = $user->getEmail();
        $data['enabled'] = (int)$user->isEnabled();
        $data['salt'] = $user->getSalt();
        $data['password'] = $user->getPassword();
        $data['plain_password'] = $user->getPlainPassword();
        $data['registered_at'] = $user->getRegisteredAt()->format('Y-m-d H:i:s');
        $data['update_at'] = $user->getUpdateAt()->format('Y-m-d H:i:s');
        $data['locked'] = (int)$user->getLocked();

        if ($user->getIdUser() === null) {
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, $user->getIdUser());
        }
    }

}