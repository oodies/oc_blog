<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Service;

use Blogpost\Domain\Model\Header;
use Blogpost\Infrastructure\Persistence\CQRS\HeaderReadRepository;
use Blogpost\Infrastructure\Persistence\CQRS\HeaderWriteRepository;
use Blogpost\Infrastructure\Repository\HeaderReadDataMapperRepository;
use Blogpost\Infrastructure\Repository\HeaderWriteDataMapperRepository;

/**
 * Class HeaderService
 * @package Blogpost\Infrastructure\Service
 */
class HeaderService
{
    /**
     *
     * @param string $postID
     *
     * @return Header
     */
    public function getByPostID(string $postID): Header
    {
        $headerReadService = new HeaderReadService(
            new HeaderReadRepository(
                new HeaderReadDataMapperRepository()
            )
        );
        $header = $headerReadService->getByPostID($postID);

        return $header;
    }

    /**
     * @param Header $header
     * @param string $title
     * @param string $brief
     *
     * @return Header
     */
    public function update(Header $header, string $title, string $brief): Header
    {
        $headerWriteService = new HeaderWriteService(
            new HeaderWriteRepository(
                new HeaderWriteDataMapperRepository()
            )
        );

        $header = $headerWriteService->update($header, $title, $brief);

        return $header;
    }
}