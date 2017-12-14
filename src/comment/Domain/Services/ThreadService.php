<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Domain\Services;


use Comment\Domain\Model\ThreadAggregate;
use Comment\Infrastructure\Repository\CommentRepository;
use Comment\Infrastructure\Repository\ThreadRepository;
use User\Infrastructure\Repository\UserRepository;

/**
 * Class ThreadService
 * @package Comment\Domain\Services
 */
class ThreadService
{

    public function getThread () {

    }

    /**
     * @param ThreadAggregate $threadAggregate
     *
     * @throws \Exception
     */
    public function postThread (ThreadAggregate $threadAggregate) {

        $thread = $threadAggregate->getThread();
        $comment = $threadAggregate->getComment();
        $author = $threadAggregate->getAuthor();

        /** @var ThreadRepository $threadRepository */
        $threadRepository = new ThreadRepository();
        $threadRepository->save($thread);


        /** @var UserRepository $userRepository */
        $userRepository = new UserRepository();
        $userRepository->save($author);

        $comment->setAuthorID($author->getUserID());

        /** @var CommentRepository $commentRepository */
        $commentRepository = new CommentRepository();
        $commentRepository->save($comment);
    }
}