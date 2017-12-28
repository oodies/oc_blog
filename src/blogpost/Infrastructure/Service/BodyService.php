<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Service;

use Blogpost\Domain\Model\Body;
use Blogpost\Infrastructure\Persistence\CQRS\BodyReadRepository;
use Blogpost\Infrastructure\Persistence\CQRS\BodyWriteRepository;
use Blogpost\Infrastructure\Repository\BodyReadDataMapperRepository;
use Blogpost\Infrastructure\Repository\BodyWriteDataMapperRepository;

/**
 * Class BodyService
 * @package Blogpost\Infrastructure\Service
 */
class BodyService
{
    /**
     * Get a body of the post
     *
     * @param string $postID
     *
     * @return Body
     */
    public function getByPostID(string $postID): Body
    {
        $bodyReadService = new BodyReadService(
            new BodyReadRepository(
                new BodyReadDataMapperRepository()
            )
        );
        $body = $bodyReadService->getByPostID($postID);

        return $body;
    }

    /**
     * @param Body $body
     * @param      $content
     *
     * @return Body
     */
    public function update(Body $body, string $content): Body
    {
        $bodyWriteService = new BodyWriteService(
            new BodyWriteRepository(
                new BodyWriteDataMapperRepository()
            )
        );
        $bodyWriteService->update($body, $content);

        return $body;
    }
}