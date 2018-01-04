<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/01
 */

namespace Comment\Infrastructure\Service;

use Blogpost\Domain\ValueObject\PostID;
use Comment\Domain\Model\Thread;
use Comment\Infrastructure\Persistence\CQRS\ThreadReadRepository;
use Comment\Infrastructure\Repository\ThreadReadDataMapperRepository;

/**
 * Class ThreadService
 * @package Comment\Infrastructure\Service
 */
class ThreadService
{
    /**
     * @param string $postID
     *
     * @return Thread|null
     */
    public function getThreadByPostID(string $postID): ?Thread
    {
        $threadReadRepository = new ThreadReadRepository(
            new ThreadReadDataMapperRepository()
        );
        $threadReadRepository->findByPostID(new PostID($postID));
        $thread = $threadReadRepository->findByPostID(new PostID($postID));

        if ($thread) {
            return $thread;
        } else {
            return null;
        }
    }
}
