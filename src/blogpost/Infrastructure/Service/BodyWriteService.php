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
use Blogpost\Infrastructure\Persistence\CQRS\BodyWriteRepository;

/**
 * Class BodyWriteService
 * @package Blogpost\Infrastructure\Service
 */
class BodyWriteService
{
    /** *******************************
     *  PROPERTIES
     */

    /** @var BodyWriteRepository */
    protected $repository;


    /** *******************************
     *  METHODS
     */

    /**
     * BodyWriteService constructor.
     *
     * @param BodyWriteRepository $repository
     */
    public function __construct(BodyWriteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a content of this post
     *
     * @param string $postID
     * @param string $content
     *
     * @return Body
     */
    public function create(string $postID, string $content): Body
    {
        $body = new Body();
        $body->create(new PostID($postID), $content);
        $this->repository->add($body);

        return $body;
    }

    /**
     * @param Body $body
     * @param      $content
     *
     * @return Body
     */
    public function update(Body $body, string $content): Body
    {
        $body->setContent($content);
        $this->repository->add($body);

        return $body;
    }
}
