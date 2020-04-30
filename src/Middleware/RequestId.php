<?php

declare(strict_types=1);

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Middleware;

use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Middleware adding a unique request id to the request if it is not present.
 */
class RequestId implements HttpKernelInterface
{
    /** @var HttpKernelInterface */
    private $app;

    /** @var string */
    private $header;

    /** @var string */
    private $responseHeader;

    /**
     * Class Constructor.
     *
     * @param mixed $header
     * @param mixed $responseHeader
     */
    public function __construct(
        HttpKernelInterface $app,
        $header = 'X-Correlation-ID',
        $responseHeader = 'X-Correlation-ID'
    ) {
        $this->app = $app;
        $this->header = $header;
        $this->responseHeader = $responseHeader;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        if (!$request->headers->has($this->header)) {
            $request->headers->set($this->header, Uuid::uuid4()->toString());
        }

        $response = $this->app->handle($request, $type, $catch);

        if ($this->responseHeader) {
            $response->headers->set($this->responseHeader, $request->headers->get($this->header));
        }

        return $response;
    }
}
