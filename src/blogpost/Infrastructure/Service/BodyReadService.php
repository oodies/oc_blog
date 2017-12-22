<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Service;

use Blogpost\Domain\Model\Body;
use Blogpost\Domain\ValueObject\PostID;
use Blogpost\Infrastructure\Persistence\CQRS\BodyReadRepository;


/**
 * Class BodyReadService
 * @package Blogpost\Infrastructure\Service
 */
class BodyReadService
{
    /** @var BodyReadRepository */
    protected $repository;

    /**
     * BodyReadService constructor.
     *
     * @param BodyReadRepository $repository
     */
    public function __construct(BodyReadRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get a body of the post
     *
     * @param string $postID
     *
     * @return Body
     */
    public function getByPostID(string $postID)
    {
        return $this->repository->getByPostID(new PostID($postID));
    }
}