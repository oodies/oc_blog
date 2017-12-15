<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Domain\Services;

use Comment\Domain\Model\ThreadAggregate;
use Comment\Infrastructure\Repository\ThreadRepository;

/**
 * Class ThreadService
 * @package Comment\Domain\Services
 */
class ThreadService
{

    /**
     *
     */
    public function getThread () {
        // TODO to implement
    }

    /**
     * Create or update Thread and create Comment
     *
     * @param ThreadAggregate $threadAggregate
     *
     * @throws \Exception
     *
     * @return void
     */
    public function postThread (ThreadAggregate $threadAggregate): void {

        $thread = $threadAggregate->getThread();
        $comments = $threadAggregate->getComments();

        /** @var ThreadRepository $threadRepository */
        $threadRepository = new ThreadRepository();
        $threadRepository->save($thread);

        $comment = $comments->offsetGet(0)->getComment();

        $commentService = new CommentService();
        $commentService->postComment($comment);
    }
}