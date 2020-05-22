<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Service;

use App\Repository\ItemRepository;

/**
 * Item Service.
 */
class ItemService
{
    /** @var ItemRepository */
    private $itemRepository;

    /**
     * Class Constructor.
     */
    public function __construct(
        ItemRepository $itemRepository
    ) {
        $this->itemRepository = $itemRepository;
    }
}
