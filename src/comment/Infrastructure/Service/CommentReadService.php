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
use Comment\Infrastructure\Persistence\CQRS\CommentReadRepository;
use Comment\Infrastructure\Persistence\CQRS\ThreadReadRepository;
use Comment\Infrastructure\Repository\CommentRepository;
use Comment\Infrastructure\Repository\ThreadReadDataMapperRepository;
use User\Infrastructure\Persistence\CQRS\ReadRepository;
use User\Infrastructure\Repository\ReadDataMapperRepository;
use User\Infrastructure\Service\UserReadService;

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
     * Return a comments list
     *
     */
    public function getComments()
    {
        /** @var UserReadService $userReadService */
        $userReadService = new UserReadService(
            new ReadRepository(
                new ReadDataMapperRepository())
        );
        /** @var ThreadReadService $threadReadService */
        $threadReadService = new ThreadReadService(
            new ThreadReadRepository(
                new ThreadReadDataMapperRepository()
            )
        );
        /** @var BlogpostService $postReadService */
        $blogpostService = new BlogpostService();

        $response = [];

        /** @var CommentRepository $commentRepository */
        $commentRepository = new CommentRepository();
        $comments = $commentRepository->findAll();

        /** @var Comment $comment */
        foreach ($comments as $comment) {
            $commentAggregate = new CommentAggregate();
            $commentAggregate->setComment($comment);

            $author = $userReadService->getByUserID($comment->getAuthorID());
            $thread = $threadReadService->getByThreadID($comment->getThreadID()->getValue());
            $post = $blogpostService->getBlogpost($thread->getPostID()->getValue());

            $commentAggregate->setPostAggregate($post);
            $commentAggregate->setAuthor($author);

            $response[] = $commentAggregate;
        }

        return $response;
    }


    public function getByThreadID()
    {

    }
}