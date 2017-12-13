<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace User\Domain\ValueObject;

use Ramsey\Uuid\Uuid;

/**
 * Class UserID
 * @package User\Domain\ValueObject
 */
class UserID
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
     * @return UserID
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
     * @return string
     */
    public function getValue(): string
    {
        return $this->Uuid;
    }
}