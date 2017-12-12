<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Repository;

use Blogpost\Domain\Model\Header;
use Blogpost\Domain\ValueObject\PostID;
use Blogpost\Infrastructure\Repository\TableGateway\HeaderTableGateway;
use Lib\Db\AbstractRepository;

/**
 * Class HeaderRepository
 * @package Blogpost\Infrastructure\Repository
 */
class HeaderRepository extends AbstractRepository
{
    /** *******************************
     *      PROPERTIES
     * ********************************/

    /** @var string $gatewayName */
    protected $gatewayName = HeaderTableGateway::class;


    /** *******************************
     *      METHODS
     * ********************************/

    /**
     * Fetches a row by 'postID' foreign key
     *
     * @param PostID $postId
     *
     * @return Header
     */
    public function findByPostID(PostID $postID): Header
    {
        /** @var Header $header */
        $header = new header();

        $row = $this->getDbTable()->findByPostId($postID->getValue());
        // Hydrate
        if ($row !== false) {
            $header
                ->setIdHeader($row['id_header'])
                ->setTitle($row['title'])
                ->setBrief($row['brief'])
                ->setPostID($postID);
        }
        return $header;
    }

    /**
     *
     * @return array
     */
    public function findAll()
    {
        $rowSet = $this->getDbTable()->findAll();

        $entries = [];
        if (count($rowSet)) {
            foreach ($rowSet as $key => $row) {
                $header = new Header();
                $header
                    ->setIdHeader($row['id_header'])
                    ->setTitle($row['title'])
                    ->setBrief($row['brief'])
                    ->setPostID(new PostID($row['postID']));
                $entries[] = $header;
            }
        }
        return $entries;
    }

    /**
     * Persist model
     *
     * @param Header $header
     *
     * @throws \Exception
     */
    public function save(Header $header)
    {
        $data['title'] = $header->getTitle();
        $data['brief'] = $header->getBrief();
        $data['postID'] = $header->getPostID()->getValue();

        if ($header->getIdHeader() === null) {
           $this->getDbTable()->insert($data);
        } else {
           $this->getDbTable()->update($data, $header->getIdHeader());
        }
    }
}