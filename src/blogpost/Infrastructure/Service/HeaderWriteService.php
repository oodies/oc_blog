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
use Blogpost\Infrastructure\Persistence\CQRS\HeaderWriteRepository;

class HeaderWriteService
{
    /** *******************************
     *  PROPERTIES
     */

    /** @var HeaderWriteRepository */
    protected $repository;


    /** *******************************
     *  METHODS
     */

    /**
     * HeaderWriteService constructor.
     *
     * @param HeaderWriteRepository $repository
     */
    public function __construct(HeaderWriteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $postID
     * @param string $title
     * @param string $brief
     *
     * @return Header
     */
    public function create(string $postID, string $title, string $brief): Header
    {
        $header = new Header();
        $header->create(new PostID($postID), $title, $brief);
        $this->repository->add($header);

        return $header;
    }

    /**
     * @param Header $header
     * @param string $title
     * @param string $brief
     *
     * @return Header
     */
    public function update(Header $header, string $title, string $brief): Header
    {
        $header
            ->setTitle($title)
            ->setBrief($brief);
        $this->repository->add($header);

        return $header;
    }
}
