<?php
/**
 * Created by PhpStorm.
 * User: Sébastien CHOMY
 * Date: 05/12/2017
 * Time: 22:40
 */

namespace Blogpost\Domain\Model;

/**
 * Class Person
 * @package Blogpost\Domain\Model
 */
class Person
{

    /** *******************************
     *  ATTRIBUTES
     */

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


    /** *******************************
     *  GETTER/SETTER
     */

    /**
     * @return mixed
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param mixed $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     *
     * @return Person
     */
    public function setFirstname(string $firstname): Person
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     *
     * @return Person
     */
    public function setLastname(string $lastname): Person
    {
        $this->lastname = $lastname;
        return $this;
    }
}