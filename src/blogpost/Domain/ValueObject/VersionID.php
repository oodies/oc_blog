<?php
/**
 * Created by PhpStorm.
 * User: Sébastien CHOMY
 * Date: 30/11/2017
 * Time: 22:43
 */

namespace Blogpost\Domain\ValueObject;

use Ramsey\Uuid\Uuid;

/**
 * Class VersionID
 * @package Blogpost\Domain\ValueObject
 */
class VersionID
{
    /** *******************************
     *  ATTRIBUTES
     */

    /**
     * @var string $Uuid
     */
    protected $Uuid;


    /** @var \DateTime $date */
    protected $date;


    /** *******************************
     *  METHODS
     */

    /**
     * VersionID constructor.
     *
     * @param string $Uuid
     *
     * @return VersionID
     */
    public function __construct(string $Uuid = null)
    {
        if ($Uuid == null) {
            $Uuid = Uuid::uuid4()->toString();
        }
        $this->Uuid = $Uuid;

        return $this;
    }

    /** *******************************
     *  GETTER/SETTER
     */

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->Uuid;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return VersionID
     */
    public function setDate(\DateTime $date): VersionID
    {
        $this->date = $date;
        return $this;
    }
}