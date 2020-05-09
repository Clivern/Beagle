<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Utils;

/**
 * Config Utils.
 */
class Config
{
    /** @var array */
    private $configs;

    /**
     * Class Constructor.
     */
    public function __construct()
    {
        $this->configs = array_change_key_case($_ENV, CASE_LOWER);
    }

    /**
     * Get Config.
     *
     * @param null|mixed $default
     */
    public function get(string $key, $default = null)
    {
        $key = mb_strtolower($key);

        return (isset($this->configs[$key])) ? $this->configs[$key] : $default;
    }
}
