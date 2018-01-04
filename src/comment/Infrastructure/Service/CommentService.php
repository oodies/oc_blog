<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Infrastructure\Service;

use Blogpost\Domain\ValueObject\PostID;
use Comment\Infrastructure\Persistence\CQRS\CommentReadRepository;
use Comment\Infrastructure\Persistence\CQRS\ThreadReadRepository;
use Comment\Infrastructure\Repository\CommentReadDataMapperRepository;
use Comment\Infrastructure\Repository\ThreadReadDataMapperRepository;

/**
 * Class CommentService
 * @package Comment\Infrastructure\Service
 */
class CommentService
{
    /**
     * @param string $postID
     *
     * @return array
     */
    public function getCommentsByPostID(string $postID)
    {
        /** @var ThreadReadRepository $threadReadRepository */
        $threadReadRepository = new ThreadReadRepository(
            new ThreadReadDataMapperRepository()
        );
        $threadReadRepository->findByPostID(new PostID($postID));
        $thread = $threadReadRepository->findByPostID(new PostID($postID));

        if ($thread) {
            $commentReadService = new CommentReadService(
                new CommentReadRepository(
                    new CommentReadDataMapperRepository()
                )
            );
            return $commentReadService->getByThreadID($thread->getThreadID()->getValue());
        } else {
            return array();
        }
    }
}
