<?php

declare(strict_types=1);

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * ItemCollection Model.
 */
class ItemCollection
{
    /** @var array */
    private $items;

    /** @var Meta */
    private $meta;

    /**
     * Get offset.
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Get meta.
     *
     * @SerializedName("_meta")
     */
    public function getMeta(): Meta
    {
        return $this->meta;
    }

    /**
     * Set meta.
     */
    public function setMeta(Meta $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Set items.
     */
    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }
}
