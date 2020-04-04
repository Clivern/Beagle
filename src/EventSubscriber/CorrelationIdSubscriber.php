<?php

declare(strict_types=1);

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\EventSubscriber;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Validator\GenericValidator;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * CorrelationIdSubscriber Class.
 */
class CorrelationIdSubscriber
{
    /** @var RequestStack $requestStack */
    private $requestStack;

    /**
     * Class Constructor.
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function __invoke(array $record)
    {
        $request = $this->requestStack->getCurrentRequest();
        $Validator = new GenericValidator();

        if (!empty($request->headers->get('X-Correlation-ID'))
            && $Validator->validate($request->headers->get('X-Correlation-ID'))) {
            $record['extra']['CorrelationId'] = $request->headers->get('X-Correlation-ID');

            return $record;
        }

        $uuid = Uuid::uuid4()->toString();

        $record['extra']['CorrelationId'] = $uuid;

        return $record;
    }
}
