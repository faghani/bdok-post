<?php

namespace Bdok\PostGateway\Exceptions;

use Exception;

class InvalidApiKeyException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
