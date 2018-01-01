<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Infrastructure\Service;

use Blogpost\Infrastructure\Service\BlogpostService;
use Comment\Domain\Model\Comment;
use Comment\Domain\Model\CommentAggregate;
use Comment\Domain\ValueObject\CommentID;
use Comment\Domain\ValueObject\ThreadID;
use Comment\Infrastructure\Persistence\CQRS\CommentReadRepository;
use Comment\Infrastructure\Repository\CommentReadDataMapperRepository;
use Comment\Infrastructure\Repository\ThreadReadDataMapperRepository;
use Comment\Infrastructure\Persistence\CQRS\ThreadReadRepository;
use User\Infrastructure\Service\UserService;

/**
 * Class CommentReadService
 * @package Comment\Infrastructure\Service
 */
class CommentReadService
{
    /** @var CommentReadRepository */
    protected $repository;

    public function __construct(CommentReadRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Return all comments list
     *
     */
    public function getComments()
    {
        /** @var UserService $userService */
        $userService = new UserService();
        /** @var ThreadReadService $threadReadService */
        $threadReadService = new ThreadReadService(
            new ThreadReadRepository(
                new ThreadReadDataMapperRepository()
            )
        );
        /** @var BlogpostService $postReadService */
        $blogpostService = new BlogpostService();

        $response = [];

        /** @var CommentReadRepository $commentReadRepository */
        $commentReadRepository = new CommentReadRepository(
            new CommentReadDataMapperRepository()
        );
        $comments = $commentReadRepository->findAll();

        /** @var Comment $comment */
        foreach ($comments as $comment) {
            $commentAggregate = new CommentAggregate();
            $commentAggregate->setComment($comment);

            $author = $userService->getByUserID($comment->getAuthorID()->getValue());
            $thread = $threadReadService->getByThreadID($comment->getThreadID()->getValue());
            $post = $blogpostService->getBlogpost($thread->getPostID()->getValue());

            $commentAggregate->setPostAggregate($post);
            $commentAggregate->setAuthor($author);

            $response[] = $commentAggregate;
        }

        return $response;
    }

    /**
     * Return comments list by ThreadID
     *
     * @param string $threadID
     *
     * @return array
     */
    public function getByThreadID(string $threadID)
    {
        /** @var UserService $userService */
        $userService = new UserService();
        /** @var ThreadReadService $threadReadService */
        $threadReadService = new ThreadReadService(
            new ThreadReadRepository(
                new ThreadReadDataMapperRepository()
            )
        );
        /** @var BlogpostService $postReadService */
        $blogpostService = new BlogpostService();

        $response = [];

        /** @var CommentReadRepository $commentReadRepository */
        $commentReadRepository = new CommentReadRepository(
            new CommentReadDataMapperRepository()
        );
        $comments = $commentReadRepository->findAllByThreadID(new ThreadID($threadID));

        /** @var Comment $comment */
        foreach ($comments as $comment) {
            $commentAggregate = new CommentAggregate();
            $commentAggregate->setComment($comment);

            $author = $userService->getByUserID($comment->getAuthorID()->getValue());
            $thread = $threadReadService->getByThreadID($comment->getThreadID()->getValue());
            $post = $blogpostService->getBlogpost($thread->getPostID()->getValue());

            $commentAggregate->setPostAggregate($post);
            $commentAggregate->setAuthor($author);

            $response[] = $commentAggregate;
        }

        return $response;
    }

    /**
     * Return a comment by commentID
     *
     * @param string $commentID
     *
     * @return Comment
     */
    public function getByCommentID(string $commentID): Comment
    {
        $commentReadRepository = new CommentReadRepository(
            new CommentReadDataMapperRepository()
        );

        return $comment = $commentReadRepository->getByCommentID(new CommentID($commentID));
    }
}