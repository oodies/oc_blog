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
        $threadAggregate = new ThreadAggregate();

        /** @var ThreadRepository $threadRepository */
        $threadRepository = new ThreadRepository();
        $thread = $threadRepository->findByPostID(new PostID($postID));

        $threadAggregate->setThread($thread);

        /** @var CommentRepository $commentRepository */
        $commentRepository = new CommentRepository();
        $comments = $commentRepository->findByThreadID($thread->getThreadID());

        $commentTab = [];
        foreach ($comments as $comment) {
            $userService = new UserService();
            /** @var Comment $comment */
            $author = $userService->getUser($comment->getAuthorID()->getValue());

            $commentAggregate = new CommentAggregate();
            $commentAggregate->setComment($comment);
            $commentAggregate->setAuthor($author);

            $commentTab[] = $commentAggregate;
        }
        $threadAggregate->setComments($commentTab);

        return $threadAggregate;
    }


    public function postComment(Comment $comment)
    {
        $commentRepository = new CommentRepository();
        $commentRepository->save($comment);
    }
}