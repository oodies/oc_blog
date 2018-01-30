<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Presentation\Controller;

use Blogpost\Infrastructure\Service\BlogpostService;
use Blogpost\Infrastructure\Service\PostService;
use Comment\Domain\Model\CommentAggregate;
use Comment\Infrastructure\Service\CommentService;
use Comment\Infrastructure\Service\ThreadService;
use Lib\Controller\Controller;
use Lib\HTTPFoundation\HTTPResponse;

/**
 * Class GetBlogpost
 * @package Blogpost\presentation\Controller
 */
class GetBlogpost extends Controller
{

    /** @var CommentAggregate $commentAggregate1 */
    /**
     * @param CommentAggregate $commentAggregate1
     * @param CommentAggregate $commentAggregate2
     *
     * @return int
     */
    protected function sortedByCreateDate(CommentAggregate $commentAggregate1, CommentAggregate $commentAggregate2)
    {
        $date1 = $commentAggregate1->getComment()->getCreateAt();
        $date2 = $commentAggregate2->getComment()->getCreateAt();

        if ($date1 == $date2) {
            return 0;
        }
        return ($date1 < $date2) ? -1 : 1;
    }

    /**
     * Get a single blogpost
     * with this comments
     *
     * @param string $postID
     *
     * @throws \Exception
     */
    public function getBlogpostAction($postID)
    {
        $postService = new PostService();
        $post = $postService->getByPostID($postID);

        if( is_null($post) ) {
            HTTPResponse::redirect404();
        }

        $blogpostService = new BlogpostService();
        $postAggregate = $blogpostService->getBlogpost($postID);

        $threadService = new ThreadService();
        $thread = $threadService->getThreadByPostID($postID);

        $commentService = new CommentService();
        $comments = $commentService->getCommentsByPostID($postID);

        uasort($comments, [$this , 'sortedByCreateDate']);

        echo $this->render('blogpost:blogpost:blogpost.html.twig', [
            'post' => $postAggregate,
            'thread' => $thread,
            'comments' => $comments
        ]);
    }
}
