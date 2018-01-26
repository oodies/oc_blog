<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/01
 */

namespace Blogpost\Infrastructure\Service;

use Lib\Validator\AbstractConstraintValidator;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Class ConstraintValidator
 *
 * @package Blogpost\Infrastructure\Service
 */
class ConstraintValidator extends AbstractConstraintValidator
{
    /**
     * @return Collection
     */
    public static function getCollectionConstraint()
    {
        $collectionConstraint = new Collection(
            [
                'title'   => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ],
                'brief'   => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ],
                'content' => [
                    new NotBlank(),
                ],
            ]
        );

        return $collectionConstraint;
    }
}
