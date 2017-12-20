<?php
/**
 * Created by PhpStorm.
 * User: Sébastien CHOMY
 * Date: 05/12/2017
 * Time: 22:20
 */

namespace User\Domain\Model;

use User\Domain\ValueObject\UserID;

/**
 * Class User
 * @package User\Domain\Model
 */
class User
{

    /** *******************************
     *  ATTRIBUTES
     */

    /** @var integer */
    protected $idUser;

    /** @var UserID */
    protected $userID;

    /**
     * Contains the nickname of the person
     * @var  string $nickname
     */
    protected $nickname;

    /**
     * Contains the firstname of the person
     * @var string $firstName
     */
    protected $firstname;

    /**
     * Contains the lastname of the person
     * @var string $lastName
     */
    protected $lastname;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var bool
     */
    protected $enabled = false;

    /**
     * The salt to use for hashing.
     *
     * @var string
     */
    protected $salt;

    /**
     * Encrypted password. Must be persisted.
     *
     * @var string
     */
    protected $password;

    /**
     * Plain password. Used for model validation. Must not be persisted.
     *
     * @var string
     */
    protected $plainPassword;

    /**
     * Date of registration
     *
     * @var \DateTime
     */
    protected $registeredAt;

    /**
     * Last update date
     *
     * @var \DateTime
     */
    protected $updateAt;

    /**
     * user is locked ?
     *
     * @var boolean
     */
    protected $locked;



    /** *******************************
     *  CONSTRUCT
     */

    /**
     * User constructor.
     *
     * @param null|UserID $userID
     */
    public function __construct(?UserID $userID = null)
    {
        if ($userID === null) {
            $userID = new UserID();
        }
        $this->setUserID($userID);
    }


    /** *******************************
     *  GETTER/SETTER
     */

    /**
     * @return null|int
     */
    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    /**
     * @param null|int $idUser
     *
     * @return User
     */
    public function setIdUser(?int $idUser): User
    {
        $this->idUser = $idUser;
        return $this;
    }

    /**
     * @return UserID
     */
    public function getUserID(): UserID
    {
        return $this->userID;
    }

    /**
     * @param UserID $userID
     *
     * @return User
     */
    public function setUserID(UserID $userID): User
    {
        $this->userID = $userID;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param null|string $username
     *
     * @return User
     */
    public function setUsername(?string $username): User
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     *
     * @return User
     */
    public function setEmail(?string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     *
     * @return User
     */
    public function setEnabled(bool $enabled): User
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * @param null|string $salt
     *
     * @return User
     */
    public function setSalt(?string $salt): User
    {
        $this->salt = $salt;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param null|string $password
     *
     * @return User
     */
    public function setPassword(?string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param null|string $plainPassword
     *
     * @return User
     */
    public function setPlainPassword(?string $plainPassword): User
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * @param null|string $nickname
     *
     * @return User
     */
    public function setNickname(?string $nickname): User
    {
        $this->nickname = $nickname;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param null|string $firstname
     *
     * @return User
     */
    public function setFirstname(?string $firstname): User
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param null|string $lastname
     *
     * @return User
     */
    public function setLastname(?string $lastname): User
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getRegisteredAt(): \DateTime
    {
        return $this->registeredAt;
    }

    /**
     * @param \DateTime $registeredAt
     *
     * @return User
     */
    public function setRegisteredAt(\DateTime $registeredAt): User
    {
        $this->registeredAt = $registeredAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateAt(): \DateTime
    {
        return $this->updateAt;
    }

    /**
     * @param \DateTime $updateAt
     *
     * @return User
     */
    public function setUpdateAt(\DateTime $updateAt): User
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    /**
     * @return bool
     */
    public function getLocked(): bool
    {
        return $this->locked;
    }

    /**
     * @param bool $enabled
     *
     * @return User
     */
    public function setLocked(bool $locked): User
    {
        $this->locked = $locked;
        return $this;
    }

    /** *******************************
     *  BEHAVIOR OF THE OBJECT MODEL
     */

    /**
     * @param array  $data
     */
    public function createUser(array $data)
    {
        $date = new \DateTime();

        $this->username = $data['username']?? null;
        $this->email = $data['email']?? null;
        $this->registeredAt = $date;
        $this->updateAt = $date;
        $this->locked = false;
    }

    /**
     * @param User $user
     */
    public function updateUser(User $user)
    {
        $user->updateAt = new \DateTime();
    }

    /**
     * Lock user
     */
    public function lock()
    {
        $this->locked = true;
        $this->updateAt = new \DateTime();
    }

    /**
     * Unlock user
     */
    public function unlock()
    {
        $this->locked = false;
        $this->updateAt = new \DateTime();
    }

    /**
     * @return bool
     */
    public function isLocked(): bool
    {
        return (boolean) $this->locked;
    }

}