<?php

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Exception;

use Exception;

/**
 * Class TurtleException.
 */
class TurtleException extends Exception
{
    /** @var string $errorCode */
    protected $errorCode = ErrorCodes::TURTLE_EXCEPTION;

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            'Exception \'%s\' triggered with error code %s:%s%s',
            \get_class($this),
            $this->getErrorCode(),
            PHP_EOL,
            parent::__toString()
        );
    }

    /**
     * @return string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param string $errorCode
     *
     * @return TurtleException
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;

        return $this;
    }
}
