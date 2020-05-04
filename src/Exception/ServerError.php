<?php

declare(strict_types=1);

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Exception;

use Exception;

/**
 * Class ServerError.
 */
class ServerError extends BaseException
{
    /** @var string */
    protected $httpCode = 500;

    /**
     * Class Constructor.
     *
     * @param string $httpCode
     * @param string $errorCode
     * @param int    $code
     */
    public function __construct(
        string $message,
        int $httpCode,
        $errorCode = ErrorCodes::ERROR001,
        $code = 0,
        Exception $previous = null
    ) {
        parent::__construct($message, $errorCode, $code, $previous);
        $this->setHttpCode($httpCode);
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

    /**
     * @return string
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * @param string $errorCode
     * @param mixed  $httpCode
     *
     * @return ServerError
     */
    public function setHttpCode(int $httpCode)
    {
        $this->httpCode = $httpCode;

        return $this;
    }
}
