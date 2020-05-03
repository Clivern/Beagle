<?php

declare(strict_types=1);

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Module;

use JsonSchema\Validator as JsonValidator;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Validator Module.
 */
class Validator
{
    /** @var KernelInterface */
    private $appKernel;

    /**
     * Class Constructor.
     */
    public function __construct(KernelInterface $appKernel)
    {
        $this->appKernel = $appKernel;
    }

    /**
     * Validate JSON against JSON Schema.
     */
    public function validate(string $data, string $schemaName): array
    {
        $validator = new JsonValidator();

        $validator->validate(
            json_decode($data),
            (object) [
                '$ref' => 'file://'.realpath(sprintf(
                    '%s/schemas/%s',
                    $this->appKernel->getProjectDir(),
                    $schemaName
                )),
            ]
        );

        $messages = [];

        if ($validator->isValid()) {
            return $messages;
        }

        foreach ($validator->getErrors() as $error) {
            $messages[] = $error['property'].': '.$error['message'];
        }

        return $messages;
    }
}
