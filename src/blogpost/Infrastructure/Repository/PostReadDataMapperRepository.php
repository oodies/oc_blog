<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Repository;

use Blogpost\Domain\Model\Post;
use Blogpost\Domain\Repository\PostReadRepositoryInterface;
use Blogpost\Domain\ValueObject\BloggerID;
use Blogpost\Domain\ValueObject\PostID;
use Blogpost\Infrastructure\Repository\TableGateway\PostTableGateway;
use Lib\Db\AbstractRepository;

/**
 * Class PostReadDataMapperRepository
 * @package Blogpost\Infrastructure\Repository
 */
class PostReadDataMapperRepository extends AbstractRepository implements PostReadRepositoryInterface
{

    /** @var string */
    protected $gatewayName = PostTableGateway::class;

    /**
     * Get the post
     *
     * @param PostID $postID
     *
     * @return Post
     */
    public function getByPostID(PostID $postID): Post
    {
        $post = new Post();

        $row = $this->getDbTable()->findByPostId($postID->getValue());
        if ($row !== false) {
            $this->hydrate($post, $row);
        }

        return $post;
    }

    /**
     * Gives all posts
     *
     * @return array
     */
    public function findAll(): array
    {
        $entries = [];

        $rowSet = $this->getDbTable()->findAll();
        if (count($rowSet)) {
            foreach ($rowSet as $key => $row) {
                $post = new Post();
                $this->hydrate($post, $row);
                $entries[] = $post;
                unset($post);
            }
        }

        return $entries;
    }


    /**
     * @param Post  $post
     * @param array $row
     */
    protected function hydrate(Post $post, array $row)
    {
        $post
            ->setIdPost($row['id_post'])
            ->setPostID(new PostID($row['postID']))
            ->setBloggerID(new BloggerID($row['bloggerID']))
            ->setCreateAt(new \DateTime($row['create_at']))
            ->setUpdateAt(new \DateTime($row['update_at']))
        ;
    }

    /**
     * @return PostTableGateway
     */
    protected function getDbTable(): PostTableGateway
    {
        return parent::getDbTable();
    }
}
