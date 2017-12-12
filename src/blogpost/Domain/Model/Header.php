<?php
/**
 * Created by PhpStorm.
 * User: Sébastien CHOMY
 * Date: 02/12/2017
 * Time: 10:41
 */

namespace Blogpost\Domain\Model;

use Blogpost\Domain\ValueObject\PostID;

/**
 * Class Header
 * @package Blogpost\Domain\Model
 */
class Header
{
    /** *******************************
     *  ATTRIBUTES
     */

    /** @var integer */
    protected $idHeader;

    /** @var string $title */
    protected $title;

    /** @var string $brief */
    protected $brief;

    /**
     * Object-Value
     */

    /** @var PostID */
    protected $postID;


    /** *******************************
     *  GETTER/SETTER
     */

    /**
     * @return int
     */
    public function getIdHeader(): int
    {
        return $this->idHeader;
    }

    /**
     * @param int $idHeader
     *
     * @return Header
     */
    public function setIdHeader(int $idHeader): Header
    {
        $this->idHeader = $idHeader;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the 'title' property
     *
     * @param string|null $title
     *
     * @return Header
     */
    public function setTitle(?string $title): Header
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBrief()
    {
        return $this->brief;
    }

    /**
     * @param string|null $brief
     *
     * @return  Header
     */
    public function setBrief(?string $brief): Header
    {
        $this->brief = $brief;
        return $this;
    }

    /**
     * @return PostID
     */
    public function getPostID(): PostID
    {
        return $this->postID;
    }

    /**
     * @param PostID $postID
     *
     * @return Header
     */
    public function setPostID(PostID $postID): Header
    {
        $this->postID = $postID;
        return $this;
    }
}