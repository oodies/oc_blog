<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Domain\Services;

use Blogpost\Domain\Services\BlogpostService;
use Comment\Domain\Model\Comment;
use Comment\Domain\Model\CommentAggregate;
use Comment\Infrastructure\Repository\CommentRepository;
use Comment\Infrastructure\Repository\ThreadRepository;
use User\Infrastructure\Persistence\CQRS\ReadRepository;
use User\Infrastructure\Repository\ReadDataMapperRepository;
use User\Infrastructure\Service\UserReadService;

/**
 * Class CommentService
 * @package Comment\Domain\Services
 */
class CommentService
{
    /**
     * Return a comments list
     *
     */
    public function getComments()
    {
        /** @var CommentRepository $commentRepository */
        $commentRepository = new CommentRepository();
        $comments = $commentRepository->findAll();

        /** @var UserReadService $userReadService */
        $userReadService = new UserReadService(
            new ReadRepository(
                new ReadDataMapperRepository())
        );

        $response = [];
        foreach ($comments as $comment) {
            $commentAggregate = new CommentAggregate();
            $commentAggregate->setComment($comment);
            $commentAggregate->setAuthor(
                $userReadService->getByUserID($comment->getAuthorID())
            );

            $threadRepository = new ThreadRepository();
            $thread = $threadRepository->findByThreadID($comment->getThreadID());

            $post = (new BlogpostService())->getBlogPost($thread->getPostID()->getValue());

            $commentAggregate->setPost($post);

            $response[] = $commentAggregate;
        }

        return $response;
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