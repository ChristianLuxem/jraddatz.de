<?php

namespace JRaddatz\Web\Config\Exceptions;

use JRaddatz\Web\Exceptions\Exception;

/**
 * Class ConfigNotDefinedException
 *
 * @package JRaddatz\Web\Config\Exceptions
 */
class ConfigNotFoundException extends Exception
{

    /**
     * @var string
     */
    protected $message = 'No config has been defined for the application';

}
