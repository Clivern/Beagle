<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Module;

use SplStack;

/**
 * Defer Module.
 *
 * <code>
 * \App\Module\Defer::exec($_, function () {
 *    echo "Defer Func";
 * });
 * </code>
 */
class Defer
{
    /**
     * @param SplStack &$context
     */
    public static function exec(?SplStack &$context, callable $callback)
    {
        $context = $context ?? new SplStack();

        $context->push(
            new class($callback) {
                private $callback;

                public function __construct(callable $callback)
                {
                    $this->callback = $callback;
                }

                public function __destruct()
                {
                    \call_user_func($this->callback);
                }
            }
        );
    }
}
