<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Domain\Repository;

use Blogpost\Domain\Model\Header;

/**
 * Interface HeaderWriteRepositoryInterface
 * @package Blogpost\Domain\Repository
 */
interface HeaderWriteRepositoryInterface
{
    /**
     * Persist Header
     *
     * @param Header $header
     */
    public function add(Header $header): void;
}