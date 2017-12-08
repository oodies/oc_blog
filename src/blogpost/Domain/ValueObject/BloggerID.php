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
 * Class BloggerID
 * @package Blogpost\Domain\ValueObject
 */
class BloggerID
{
    /**
     * @var string $Uuid
     */
    protected $Uuid;

    /**
     * PostID constructor.
     *
     * @param string $Uuid
     *
     * @return BloggerID
     */
    public function __construct(string $Uuid = null)
    {
        if ($Uuid == null) {
            $Uuid = Uuid::uuid4()->toString();
        }
        $this->Uuid = $Uuid;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->Uuid;
    }
}