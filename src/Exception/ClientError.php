<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Exception;

use Exception;

/**
 * Class ClientError.
 */
class ClientError extends BaseException
{
    /** @var string */
    protected $httpCode = 400;

    /**
     * Class Constructor.
     *
     * @param string    $errorCode
     * @param int       $code
     * @param Exception $previous
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

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * @return ClientError
     */
    public function setHttpCode(int $httpCode)
    {
        $this->httpCode = $httpCode;

        return $this;
    }
}
