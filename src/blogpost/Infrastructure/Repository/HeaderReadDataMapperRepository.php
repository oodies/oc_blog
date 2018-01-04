<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Repository;

use Blogpost\Domain\Model\Header;
use Blogpost\Domain\Repository\HeaderReadRepositoryInterface;
use Blogpost\Domain\ValueObject\PostID;
use Blogpost\Infrastructure\Repository\TableGateway\HeaderTableGateway;
use Lib\Db\AbstractRepository;

/**
 * Class HeaderReadDataMapperRepository
 * @package Blogpost\Infrastructure\Repository
 */
class HeaderReadDataMapperRepository extends AbstractRepository implements HeaderReadRepositoryInterface
{
    /** *******************************
     *      PROPERTIES
     */

    /** @var string $gatewayName */
    protected $gatewayName = HeaderTableGateway::class;


    /** *******************************
     *      METHODS
     */

    /**
     * Get the header of the post
     *
     * @param PostID $postID
     *
     * @return Header
     */
    public function getByPostID(PostID $postID): Header
    {
        /** @var Header $header */
        $header = new header();

        $row = $this->getDbTable()->findByPostId($postID->getValue());
        if ($row !== false) {
            $this->hydrate($header, $row);
        }

        return $header;
    }

    /**
     * Gives the header of all post
     *
     * @return array
     */
    public function findAll(): array
    {
        $entries = [];

        $rowSet = $this->getDbTable()->findAll();
        if (count($rowSet)) {
            foreach ($rowSet as $key => $row) {
                $header = new Header();
                $this->hydrate($header, $row);
                $entries[] = $header;
                unset($header);
            }
        }

        return $entries;
    }

    /**
     * Hydrate Header object with data of the row
     *
     * @param Header $header
     * @param array  $row
     */
    protected function hydrate(Header $header, array $row)
    {
        $header
            ->setIdHeader($row['id_header'])
            ->setTitle($row['title'])
            ->setBrief($row['brief'])
            ->setPostID(new PostID($row['postID']));
    }

    /**
     * @return HeaderTableGateway
     */
    protected function getDbTable(): HeaderTableGateway
    {
        return parent::getDbTable();
    }
}
