<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Domain\Services;

use Blogpost\Domain\ValueObject\PostID;
use Comment\Domain\Model\CommentAggregate;
use Comment\Domain\Model\Thread;
use Comment\Domain\Model\ThreadAggregate;
use Comment\Infrastructure\Repository\ThreadRepository;
use Comment\Infrastructure\Repository\CommentRepository;
use User\Infrastructure\Persistence\CQRS\ReadRepository;
use User\Infrastructure\Repository\ReadDataMapperRepository;
use User\Infrastructure\Service\UserReadService;

/**
 * Class ThreadService
 * @package Comment\Domain\Services
 */
class ThreadService
{

    /**
     *
     */
    public function getThread (string $postID) {

        /** @var ThreadRepository $threadRepository */
        $threadRepository = new ThreadRepository();
        /** @var Thread $thread */
        $thread = $threadRepository->findByPostID(new PostID($postID));

        /** @var CommentRepository $commentRepository */
        $commentRepository = new CommentRepository();
        /** @var array $comments */
        $comments = $commentRepository->findByThreadID($thread->getThreadID());

        /** @var UserReadService $userReadService */
        $userReadService = new UserReadService(
            new ReadRepository(
                new ReadDataMapperRepository())
        );

        /** @var ThreadAggregate $threadAggregate */
        $threadAggregate = new ThreadAggregate();
        $threadAggregate->setThread($thread);

        foreach ($comments as $comment) {
            /** @var CommentAggregate $commentAggregate */
            $commentAggregate = new CommentAggregate();
            $commentAggregate->setComment($comment);
            $commentAggregate->setAuthor(
                $userReadService->getByUserID($comment->getAuthorID())
            );

            $threadAggregate->setComments($commentAggregate);
        }

        return $threadAggregate;
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