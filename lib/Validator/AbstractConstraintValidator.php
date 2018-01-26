<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/01
 */

namespace Lib\Validator;

use Symfony\Component\Validator\Validation;

/**
 * Class AbstractConstraintValidator
 *
 * @package Lib\Validator\Service
 */
abstract class AbstractConstraintValidator implements ConstraintValidatorInterface
{
    /**
     * RegisterData a key table and value of the data to be validated
     * $constraintViolation is an ArrayAccess of the violation constraint
     *
     * @param array                   $registerData
     * @param ConstraintViolationList $constraintViolationList
     *
     * @return bool
     */
    public static function validateRegisterData(array $registerData, ConstraintViolationList $constraintViolationList)
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($registerData, static::getCollectionConstraint());

        if (0 != count($violations)) {
            foreach ($violations as $violation) {
                $field = substr($violation->getPropertyPath(), 1, -1);
                $constraintViolationList[$field] = $violation->getMessage();
            }
            return false;
        } else {
            return true;
        }
    }
}
