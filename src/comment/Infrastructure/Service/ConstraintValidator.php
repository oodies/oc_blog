<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/01
 */

namespace Comment\Infrastructure\Service;

use Lib\Validator\AbstractConstraintValidator;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ConstraintValidator
 *
 * @package Comment\Infrastructure\Service
 */
class ConstraintValidator extends AbstractConstraintValidator
{
    /**
     * @return Collection
     */
    public static function getCollectionConstraint () {

        $collectionConstraint = new Collection(
            [
                'username'   => [
                    new NotBlank(),
                    new Length(['max' => 255])
                ],
                'email'   => [
                    new NotBlank(),
                    new Email()
                ],
                'body' => [
                    new NotBlank()
                ],
            ]
        );

        return $collectionConstraint;
    }
}
