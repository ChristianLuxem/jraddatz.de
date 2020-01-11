<?php

namespace JRaddatz\Web\Security\Token;

/**
 * Class Token
 *
 * @package JRaddatz\Web\Security\Token
 */
class Token
{

    /**
     * @param  int $length
     * @return string
     * @throws \Exception
     */
    public static function make(int $length = 32) : string
    {
        return self::generate($length);
    }

    /**
     * @param  int $length
     * @return string
     * @throws \Exception
     */
    protected static function generate(int $length) : string
    {
        return bin2hex(random_bytes((int) ($length / 2)));
    }
}
