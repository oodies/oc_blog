<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Repository;

use Blogpost\Domain\Model\Post;
use Blogpost\Domain\ValueObject\BloggerID;
use Blogpost\Domain\ValueObject\PostID;
use Blogpost\Domain\ValueObject\VersionID;
use Blogpost\Infrastructure\Repository\TableGateway\PostTableGateway;
use Lib\Db\AbstractRepository;

/**
 * Class PostRepository
 * @package Blogpost\Infrastructure\Repository
 */
class PostRepository extends AbstractRepository
{
    /** *******************************
     *      PROPERTIES
     * ********************************/

    /** @var string $gatewayName */
    protected $gatewayName = PostTableGateway::class;


    /** *******************************
     *      METHODS
     * ********************************/

    /**
     * @param $id
     *
     * @return Post
     */
    public function find($id): Post
    {
        $post = new Post();
        $row = $this->getDbTable()->find($id);
        if ($row !== false) {
            $post
                ->setIdPost($row['id_post'])
                ->setPostID(new PostID($row['postID']))
                ->setBloggerID(new BloggerID($row['bloggerID']))
                ->setVersionID(new VersionID($row['versionID']));
        }
        return $post;
    }

    /**
     * Fetches a row by 'postID' foreign key
     *
     * @param $postId
     *
     * @return Post
     */
    public function findByPostID($postID): Post
    {
        $post = new Post();
        $row = $this->getDbTable()->findByPostId($postID);
        if ($row !== false) {
            $post
                ->setIdPost($row['id_post'])
                ->setPostID(new PostID($row['postID']))
                ->setBloggerID(new BloggerID($row['bloggerID']))
                ->setVersionID(new VersionID($row['versionID']));
        }
        return $post;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $rowSet = $this->getDbTable()->findAll();

        $entries = [];
        if (count($rowSet)) {
            foreach ($rowSet as $key => $row) {
                $post = new Post();
                $post
                    ->setIdPost($row['id_post'])
                    ->setPostID(new PostID($row['postID']))
                    ->setVersionID(new VersionID($row['versionID']))
                    ->setBloggerID(new BloggerID($row['bloggerID']));

                $entries[] = $post;
            }
        }
        return $entries;
    }

    /**
     * Persist Model
     *
     * @param Post $post
     *
     * @throws \Exception
     */
    public function save(Post $post)
    {
        $data['postID'] = $post->getPostID()->getValue();
        $data['versionID'] = $post->getVersionID()->getValue();
        $data['bloggerID'] = $post->getBloggerID()->getValue();

        if ($post->getIdPost() === null) {
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, $post->getIdPost());
        }
    }
}