<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace User\Infrastructure\Password;

/**
 * Class Encoder
 * @package User\Infrastructure\Password
 */
class Encoder
{
    /**
     * Encode password
     *
     * @param $password
     *
     * @return bool|string
     */
    public static function encode($password)
    {
        $hash = password_hash($password, PASSWORD_BCRYPT, [
            'cost' => 13
        ]);

        return $hash;
    }

    /**
     * Verifies that a password matches a hash
     *
     * @param $password
     * @param $hash
     *
     * @return bool
     */
    public function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
