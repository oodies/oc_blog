<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Persistence\CQRS;

use Blogpost\Domain\Model\Header;
use Blogpost\Domain\Repository\HeaderWriteRepositoryInterface;

/**
 * Class HeaderWriteRepository
 * @package Blogpost\Infrastructure\Persistence\CQRS
 */
class HeaderWriteRepository implements HeaderWriteRepositoryInterface
{
    /** @var HeaderWriteRepositoryInterface */
    protected $repository;

    /**
     * HeaderWriteRepository constructor.
     *
     * @param HeaderWriteRepositoryInterface $repository
     */
    public function __construct(HeaderWriteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Persist Header
     *
     * @param Header $header
     */
    public function add(Header $header): void
    {
        $this->repository->add($header);
    }
}