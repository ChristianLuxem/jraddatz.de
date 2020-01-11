<?php

namespace JRaddatz\Web\Security\Hash;

use InvalidArgumentException;
use JRaddatz\Web\Config\Config;

/**
 * Class Hash
 *
 * @package JRaddatz\Web\Security\Hash
 */
class Hash
{

    /**
     * Hash constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param  string $password
     * @param  string $pepper
     * @param  string $algorithm
     * @param  array  $options
     * @return string
     * @throws \JRaddatz\Web\Config\Exceptions\ConfigNotFoundException
     * @throws \JRaddatz\Web\Config\Exceptions\RequestedConfigNotDefinedException
     */
    public function make(string $password, string $pepper = 'ilovecats', string $algorithm = 'password_default', array $options = []) : string
    {
        if ($this->config->has('hashing.pepper')) {
            $pepper = $this->config->get('hashing.pepper');
        }

        if ($this->config->has('hashing.algorithm')) {
            $algorithm = $this->config->get('hashing.algorithm');
        }

        if ($this->config->has('hashing.options')) {
            $options = array_merge($options, $this->config->get('hashing.options'));
        }

        return $this->hash($password, $pepper, $algorithm, $options);
    }

    /**
     * @param  string $password
     * @param  string $hash
     * @param  string $pepper
     * @return bool
     * @throws \JRaddatz\Web\Config\Exceptions\ConfigNotFoundException
     * @throws \JRaddatz\Web\Config\Exceptions\RequestedConfigNotDefinedException
     */
    public function check(string $password, string $hash, string $pepper = 'ilovecats') : bool
    {
        if ($this->config->has('hashing.pepper')) {
            $pepper = $this->config->get('hashing.pepper');
        }

        return $this->verifyPassword($password, $hash, $pepper);
    }

    /**
     * @param  string $password
     * @param  string $pepper
     * @param  string $algorithm
     * @param  array  $options
     * @return string
     */
    protected function hash(string $password, string $pepper, string $algorithm, array $options) : string
    {
        $algorithm = strtolower($algorithm);

        switch ($algorithm) {
            case 'password_default':
                return password_hash($password . $pepper, PASSWORD_DEFAULT, $options);
            break;

            case 'password_bcrypt':
                return password_hash($password . $pepper, PASSWORD_BCRYPT, $options);
            break;

            case 'password_argon2i':
                return password_hash($password . $pepper, PASSWORD_ARGON2I, $options);
            break;

            case 'password_argon2id':
                return password_hash($password . $pepper, PASSWORD_ARGON2ID, $options);
            break;

            default:
                throw new InvalidArgumentException('Invalid hashing algorithm');
            break;
        }
    }

    /**
     * @param  string $password
     * @param  string $hash
     * @param  string $pepper
     * @return bool
     */
    protected function verifyPassword(string $password, string $hash, string $pepper) : bool
    {
        return password_verify($password . $pepper, $hash);
    }
}
