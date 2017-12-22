<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Service;


use Blogpost\Domain\Model\Header;
use Blogpost\Domain\ValueObject\PostID;
use Blogpost\Infrastructure\Persistence\CQRS\HeaderReadRepository;

class HeaderReadService
{
    /** @var HeaderReadRepository */
    protected $repository;

    /**
     * HeaderReadService constructor.
     *
     * @param HeaderReadRepository $repository
     */
    public function __construct(HeaderReadRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $postID
     *
     * @return Header
     */
    public function getByPostID(string $postID): Header
    {
        return $this->repository->getByPostID(new PostID($postID));
    }
}