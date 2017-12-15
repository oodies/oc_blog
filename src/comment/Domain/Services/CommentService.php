<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Domain\Services;

use Blogpost\Domain\ValueObject\PostID;
use Comment\Domain\Model\Comment;
use Comment\Domain\Model\CommentAggregate;
use Comment\Domain\Model\Thread;
use Comment\Domain\Model\ThreadAggregate;
use Comment\Infrastructure\Repository\CommentRepository;
use Comment\Infrastructure\Repository\ThreadRepository;
use User\Domain\Services\UserService;

/**
 * Class CommentService
 * @package Comment\Domain\Services
 */
class CommentService
{
    /**
     * Return a comments list by PostID
     *
     * @param string $postID
     *
     * @return ThreadAggregate
     */
    public function getComments(string $postID)
    {
        /** @var ThreadRepository $threadRepository */
        $threadRepository = new ThreadRepository();
        /** @var Thread $thread */
        $thread = $threadRepository->findByPostID(new PostID($postID));

        /** @var CommentRepository $commentRepository */
        $commentRepository = new CommentRepository();
        /** @var array $comments */
        $comments = $commentRepository->findByThreadID($thread->getThreadID());

        $threadAggregate = new ThreadAggregate();
        $threadAggregate->setThread($thread);

        foreach ($comments as $comment) {
            $commentAggregate = new CommentAggregate();
            $commentAggregate->setComment($comment);
            $commentAggregate->setAuthor(
                (new UserService())->getUser($comment->getAuthorID()->getValue())
            );

            $threadAggregate->setComments($commentAggregate);
        }

        return $threadAggregate;
    }

    /**
     * Create a new comment
     *
     * @param Comment $comment
     *
     * @throws \Exception
     *
     * @return void
     *
     */
    public function postComment(Comment $comment): void
    {
        $commentRepository = new CommentRepository();
        $commentRepository->save($comment);
    }
}