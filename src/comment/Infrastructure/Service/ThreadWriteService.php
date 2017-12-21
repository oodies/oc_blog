<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Infrastructure\Service;

use Blogpost\Domain\ValueObject\PostID;
use Comment\Domain\Model\Thread;
use Comment\Infrastructure\Persistence\CQRS\ThreadWriteRepository;

/**
 * Class ThreadWriteService
 * @package Comment\Infrastructure\Service
 */
class ThreadWriteService
{
    /** @var ThreadWriteRepository */
    protected $repository;

    /**
     * ThreadWriteService constructor.
     *
     * @param ThreadWriteRepository $repository
     */
    public function __construct(ThreadWriteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new comment feed for this identified post
     *
     * @param string $postID
     *
     * @return Thread
     */
    public function create(string $postID): Thread
    {
        $thread = new Thread();
        $thread->createThread(new PostID($postID));
        $this->repository->add($thread);

        return $thread;
    }

    /**
     * Update comment feed for a new post posted
     *
     * @param Thread $thread
     *
     * @return Thread
     */
    public function update(Thread $thread)
    {
        $thread->updateThread();
        $this->repository->add($thread);

        return $thread;
    }
}