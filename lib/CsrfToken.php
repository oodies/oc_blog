<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/02
 */

namespace Lib;

/**
 * Class CsrfToken
 *
 * @package Lib
 */
class CsrfToken
{
    /**
     * Session variable
     */
    const TOKEN_ID = '_csrf_token';


    /**
     * Generate a CSRF token.
     *
     * @return string The generated CSRF token
     */
    public function generateToken(): string
    {
        $token = bin2hex(random_bytes(20));
        $_SESSION[self::TOKEN_ID] = $token;
        return $token;
    }


    /**
     *
     * Validate whether a submitted CSRF token is the same as the one stored in
     * the session.
     *
     * @param $strToken
     */
    public function validateToken(string $token): bool
    {
        $storedToken = $_SESSION[self::TOKEN_ID];
        unset($_SESSION[self::TOKEN_ID]);

        return $storedToken === $token;
    }
}
