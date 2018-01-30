<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Presentation\Controller;

use Blogpost\Infrastructure\Service\BlogpostService;
use Lib\Controller\Controller;

/**
 * Class GetBlogposts
 *
 * @package Blogpost\Presentation\Controller
 */
class GetBlogposts extends Controller
{
    /**
     * Return a blogpost list
     */
    public function getBlogpostsAction()
    {
        $blogpostService = new BlogpostService();
        $posts = $blogpostService->getBlogposts();

        uasort($posts, [$this, 'sortedByUpdateDate']);

        echo $this->render(
            'blogpost:blogpost:blogpostList.html.twig',
            ['posts' => $posts]
        );
    }

    /**
     * @param \Blogpost\Domain\Model\PostAggregate $postAggregate1
     * @param \Blogpost\Domain\Model\PostAggregate $postAggregate2
     *
     * @return int
     */
    protected function sortedByUpdateDate(
        \Blogpost\Domain\Model\PostAggregate $postAggregate1,
        \Blogpost\Domain\Model\PostAggregate $postAggregate2
    ) {
        $date1 = $postAggregate1->getUpdateAt();
        $date2 = $postAggregate2->getUpdateAt();

        if ($date1 == $date2) {
            return 0;
        }
        return ($date1 > $date2) ? -1 : 1;
    }
}
