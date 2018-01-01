<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Infrastructure\Service;

use Blogpost\Domain\ValueObject\PostID;
use Comment\Domain\Model\Author;
use Comment\Domain\Model\Comment;
use Comment\Domain\Model\Thread;
use Comment\Domain\ValueObject\AuthorID;
use Comment\Domain\ValueObject\ThreadID;
use Comment\Infrastructure\Persistence\CQRS\CommentWriteRepository;
use Comment\Infrastructure\Persistence\CQRS\ThreadReadRepository;
use Comment\Infrastructure\Persistence\CQRS\ThreadWriteRepository;
use Comment\Infrastructure\Repository\ThreadReadDataMapperRepository;
use Comment\Infrastructure\Repository\ThreadWriteDataMapperRepository;
use User\Domain\Model\User;
use User\Infrastructure\Persistence\CQRS\WriteRepository;
use User\Infrastructure\Repository\WriteDataMapperRepository;
use User\Infrastructure\Service\UserService;
use User\Infrastructure\Service\UserRegisterService;

/**
 * Class CommentWriteService
 * @package Comment\Infrastructure\Service
 */
class CommentWriteService
{
    /** @var CommentWriteRepository */
    protected $repository;

    /**
     * CommentWriteService constructor.
     *
     * @param CommentWriteRepository $repository
     */
    public function __construct(CommentWriteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new comment
     *
     * @param string $postID   The post identifier of this comment's post
     * @param string $username The username of the author of the commentary
     * @param string $email    The email address of the author of the commentary
     * @param string $body     The commentary
     *
     * @return Comment
     */
    public function create(string $postID, string $username, string $email, string $body)
    {
        // One step / Create a new author, if the author is unknown
        //
        /** @var UserService $userService */
        $userService = new UserService();
        /** @var User $likelyAuthor */
        $likelyAuthor = $userService->findByEmail($email);

        if ($likelyAuthor === null) {
            /** @var UserRegisterService $userRegisterService */
            $userRegisterService = new UserRegisterService(
                new WriteRepository(
                    new WriteDataMapperRepository()
                ));
            /** @var Author $author */
            $author = $userRegisterService->create($username, $email);
        } else {
            $author = $likelyAuthor;
        }

        // Two step / Is there already a comment feed for this post?
        //
        $threadReadRepository = new ThreadReadRepository(
            new ThreadReadDataMapperRepository()
        );
        $likelyThread = $threadReadRepository->findByPostID(new PostID($postID));

        /** @var ThreadWriteService $threadWriteService */
        $threadWriteService = new ThreadWriteService(
            new ThreadWriteRepository(
                new ThreadWriteDataMapperRepository()
            ));

        /** @var Thread $thread */
        if ($likelyThread === null) {
            $thread = $threadWriteService->create($postID);
        } else {
            $thread = $threadWriteService->update($likelyThread);
        }

        /** @var ThreadID $threadID */
        $threadID = $thread->getThreadID();
        /** @var AuthorID $authorID */
        $authorID = new AuthorID($author->getUserID()->getValue());

        /** @var Comment $comment */
        $comment = new Comment();
        $comment->createComment($authorID, $threadID, $body);
        $this->repository->add($comment);

        return $comment;
    }

    /**
     * Approve comment
     *
     * @param Comment $comment
     *
     * @return Comment
     */
    public function approve(Comment $comment): Comment
    {
        $comment->approve();
        $this->repository->add($comment);

        return $comment;
    }

    /**
     * Disapprove comment
     *
     * @param Comment $comment
     *
     * @return Comment
     */
    public function disapprove(Comment $comment): Comment
    {
        $comment->disapprove();
        $this->repository->add($comment);

        return $comment;
    }

    /**
     * Change body of this comment
     *
     * @param Comment $comment
     * @param string  $body
     *
     * @return Comment
     */
    public function changeBody(Comment $comment, string $body): Comment
    {
        $comment->changeBody($body);
        $this->repository->add($comment);

        return $comment;
    }
}