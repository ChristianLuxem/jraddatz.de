<?php

namespace JRaddatz\Web\Config\Exceptions;

use JRaddatz\Web\Exceptions\Exception;

/**
 * Class RequestedConfigNotDefinedException
 *
 * @package JRaddatz\Web\Config\Exceptions
 */
class RequestedConfigNotDefinedException extends Exception
{

    /**
     * @var string
     */
    protected $message = 'The requested config item is not defined';

}
