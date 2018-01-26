<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/01
 */

namespace Lib\Validator;

use Symfony\Component\Validator\Constraints\Collection;

interface ConstraintValidatorInterface
{
    /**
     * @return Collection
     */
    public static function getCollectionConstraint();
}
