<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="option")
 * @ORM\Entity(repositoryClass="App\Repository\OptionRepository")
 */
class Option
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="key", type="string", length=60)
     */
    private $key;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="text")
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="autoload", type="string", length=10)
     */
    private $autoload;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set key.
     *
     * @param string $key
     */
    public function setKey($key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key.
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Set value.
     *
     * @param string $value
     */
    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value.
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Set autoload.
     *
     * @param string $autoload
     */
    public function setAutoload($autoload): self
    {
        $this->autoload = $autoload;

        return $this;
    }

    /**
     * Get autoload.
     */
    public function getAutoload(): string
    {
        return $this->autoload;
    }
}
