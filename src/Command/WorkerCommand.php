<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Worker Command.
 */
class WorkerCommand extends Command
{
    protected static $defaultName = 'app:worker';

    /** @var LoggerInterface */
    private $logger;

    /**
     * Class Constructor.
     */
    public function __construct(LoggerInterface $logger)
    {
        parent::__construct();
        $this->logger = $logger;
    }

    protected function configure()
    {
        $this
            ->setDescription('a sample worker')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        while (true) {
            $this->logger->info(sprintf(
                'Process %s run at %s!',
                getmypid(),
                (new \DateTime())->format('c')
            ));

            sleep(2);
        }
    }
}
