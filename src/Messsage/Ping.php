<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Messsage;

use App\Contract\Messsage as MesssageContract;

/**
 * Ping Messsage.
 */
class Ping extends AbstractMessage implements MesssageContract
{
}
