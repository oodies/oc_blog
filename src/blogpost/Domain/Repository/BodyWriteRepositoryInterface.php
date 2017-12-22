<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Domain\Repository;

use Blogpost\Domain\Model\Body;

/**
 * Interface BodyWriteRepositoryInterface
 * @package Blogpost\Domain\Repository
 */
interface BodyWriteRepositoryInterface
{
    /**
     * Persist Body
     *
     * @param Body $body
     */
    public function add(Body $body): void;
}