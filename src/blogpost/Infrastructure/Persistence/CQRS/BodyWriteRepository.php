<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Persistence\CQRS;

use Blogpost\Domain\Model\Body;
use Blogpost\Domain\Repository\BodyWriteRepositoryInterface;

/**
 * Class BodyWriteRepository
 * @package Blogpost\Infrastructure\Persistence\CQRS
 */
class BodyWriteRepository implements BodyWriteRepositoryInterface
{
    /** @var BodyWriteRepositoryInterface */
    protected $repository;

    /**
     * BodyWriteRepository constructor.
     *
     * @param BodyWriteRepositoryInterface $repository
     */
    public function __construct(BodyWriteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Persist Body
     *
     * @param Body $body
     */
    public function add(Body $body): void
    {
        $this->repository->add($body);
    }
}
