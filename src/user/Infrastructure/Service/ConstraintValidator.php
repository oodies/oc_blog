<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/01
 */

namespace User\Infrastructure\Service;

// use Symfony\Component\Validator\Constraints\Callback;
use Lib\Validator\AbstractConstraintValidator;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class AbstractConstraintValidator
 *
 * @package User\Infrastructure\Service
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
                'username'  => [
                    new NotBlank(),
                    new Length(['max' => 255]),
//                    new Callback(
//                        [
//                            'methods' => [
//                                [self, 'isValidUniqueUsername'],
//                            ],
//                        ]
//                    ),
                ],
                'email'     => [
                    new NotBlank(),
                    new Email(),
                ],
                'firstname' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ],
                'lastname'  => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ],
                'nickname'  => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ],
                'password'  => [
                    new NotBlank(),
                    new Length(['min' => 6]),
                ],
                'role'      => [
                    new NotNull(),
                ],
            ]
        );
        $collectionConstraint->allowMissingFields = true;

        return $collectionConstraint;
    }

//    private static function isValidUniqueUsername($username) {
//
//    }
}
