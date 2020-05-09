<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Annotation;

/**
 * @Annotation
 */
class Before
{
    /**
     * @var string
     */
    public $namespace;

    /**
     * @var int
     */
    public $version;

    /**
     * @var array
     */
    public $types;
}
