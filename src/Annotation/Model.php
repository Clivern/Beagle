<?php

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