<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="job")
 * @ORM\Entity(repositoryClass="App\Repository\JobRepository")
 */
class Job
{
    const PENDING = 'pending';
    const IN_PROGRESS = 'in_progress';
    const SUCCEED = 'succeed';
    const FAILED = 'failed';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="uuid", type="string", length=60)
     */
    private $uuid;

    /**
     * @var string
     *
     * @ORM\Column(name="handler", type="string", length=100)
     */
    private $handler;

    /**
     * @var string
     *
     * @ORM\Column(name="options", type="string", length=60)
     */
    private $options;

    /**
     * @var string
     *
     * @ORM\Column(name="args", type="text")
     */
    private $args;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=20)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="result", type="text")
     */
    private $result;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="run_at", type="datetime", nullable=true)
     */
    private $runAt;

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
     * Set uuid.
     *
     * @param string $uuid
     */
    public function setUUID($uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get uuid.
     */
    public function getUUID(): string
    {
        return $this->uuid;
    }

    /**
     * Set handler.
     *
     * @param string $handler
     */
    public function setHandler($handler): self
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Get handler.
     */
    public function getHandler(): string
    {
        return $this->handler;
    }

    /**
     * Set options.
     *
     * @param string $options
     */
    public function setOptions($options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get options.
     */
    public function getOptions(): string
    {
        return $this->options;
    }

    /**
     * Set args.
     *
     * @param string $args
     */
    public function setArgs($args): self
    {
        $this->args = $args;

        return $this;
    }

    /**
     * Get args.
     */
    public function getArgs(): string
    {
        return $this->args;
    }

    /**
     * Set status.
     *
     * @param string $status
     */
    public function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Set result.
     *
     * @param string $result
     */
    public function setResult($result): self
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result.
     */
    public function getResult(): string
    {
        return $this->result;
    }

    /**
     * Set createdAt.
     *
     * @return Item
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @return Item
     */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set runAt.
     *
     * @return Item
     */
    public function setRunAt(DateTime $runAt): self
    {
        $this->runAt = $runAt;

        return $this;
    }

    /**
     * Get runAt.
     */
    public function getRunAt(): DateTime
    {
        return $this->runAt;
    }
}
