<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Presentation\Controller;

use Blogpost\Infrastructure\Service\BlogpostService;
use Comment\Domain\Model\CommentAggregate;
use Comment\Infrastructure\Service\CommentService;
use Comment\Infrastructure\Service\ThreadService;
use Lib\Controller\Controller;
use Lib\Registry;

/**
 * Class GetBlogpost
 * @package Blogpost\presentation\Controller
 */
class GetBlogpost extends Controller
{

    /** @var CommentAggregate $commentAggregate1 */
    /** @var CommentAggregate $commentAggregate2 */
    protected function sortedByCreateDate($commentAggregate1, $commentAggregate2)
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
     * @throws \Exception
     */
    public function getBlogpostAction()
    {
        $params = Registry::get('request')->getQueryParams();
        $postID = $params['id'];

        $threadService = new ThreadService();
        $thread = $threadService->getThreadByPostID($postID);

        $blogpostService = new BlogpostService();
        $post = $blogpostService->getBlogpost($postID);

        $commentService = new CommentService();
        $comments = $commentService->getCommentsByPostID($postID);

        uasort($comments, [$this , 'sortedByCreateDate']);

        echo $this->render('blogpost:blogpost:blogpost.html.twig', [
            'post' => $post,
            'thread' => $thread,
            'comments' => $comments
        ]);
    }
}
