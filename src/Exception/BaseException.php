<?php

declare(strict_types=1);

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Exception;

use Exception;

/**
 * Class BaseException.
 */
class BaseException extends Exception
{
    /** @var string */
    protected $errorCode = ErrorCodes::ERROR001;

    /**
     * Class Constructor.
     *
     * @param string $httpCode
     * @param string $errorCode
     * @param int    $code
     */
    public function __construct(
        string $message,
        $errorCode = ErrorCodes::ERROR001,
        $code = 0,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->setErrorCode($errorCode);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            'Exception \'%s\' triggered with error code %s:%s%s',
            static::class,
            $this->getErrorCode(),
            PHP_EOL,
            parent::__toString()
        );
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    /**
     * @return BaseException
     */
    public function setErrorCode(string $errorCode)
    {
        $this->errorCode = $errorCode;

        return $this;
    }
}
