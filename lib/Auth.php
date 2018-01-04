<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/01
 */

namespace Lib;

use User\Domain\Model\User;

/**
 * Authentication handler
 *
 * Class Auth
 *
 * @package Lib
 */
class Auth
{
    /** *******************************
     *  PROPERTIES
     */

    /**
     * Singleton instance
     *
     * @var Auth
     */
    protected static $_instance = null;

    /**
     * @var null|User
     */
    protected $identity;

    /**
     * @var null|$_SESSION
     */
    protected $storage = null;

    /**
     * Singleton pattern implementation makes "new" unavailable
     *
     * @return void
     */
    protected function __construct()
    {
    }

    /** *******************************
     *  METHOD
     */

    /**
     * @return Auth
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * @return null|$_SESSION
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Data session storage
     */
    public function setStorage()
    {
        $this->storage = $_SESSION;
    }

    /**
     * Push
     *  - The roles allowed
     *  - userID
     *  - User
     * in session
     *
     * @param User $user
     */
    public function authenticate(User $user)
    {
        session_regenerate_id();

        switch ($user->getRole()) {
            case 'guest':
                $roles = ['guest'];
                break;
            case 'blogger':
                $roles = ['guest', 'blogger'];
                break;
            case 'admin':
                $roles = ['guest', 'blogger', 'admin'];
                break;
            default:
                $roles = ['guest'];
                break;
        }

        $_SESSION['user'] = $user;
        $_SESSION['roles'] = $roles;
        $_SESSION['userID'] = $user->getUserID()->getValue();

        self::setStorage();
    }

    /**
     * @return null|User
     */
    public function getIdentity()
    {
        if (!self::hasIdentity()) {
            return null;
        }

        return $user = $this->storage['user'];
    }

    /**
     * @return bool
     */
    public function hasIdentity(): bool
    {
        return (isset($this->storage['userID']));
    }

    /**
     * Singleton pattern implementation makes "clone" unavailable
     *
     * @return void
     */
    protected function __clone()
    {
    }
}
