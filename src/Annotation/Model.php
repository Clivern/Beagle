<?php

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Annotation;

/**
 * @Annotation
 */
class Model
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
