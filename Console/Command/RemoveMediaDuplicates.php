<?php
declare(strict_types=1);

namespace Elevinskii\MediaStorage\Console\Command;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveMediaDuplicates extends Command
{
    /**
     * Configuration of the command
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('catalog:images:remove-duplicates')
            ->setDescription('Searches for media duplicates in database and removes them');

        parent::configure();
    }

    /**
     * Remove duplicates action
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return Cli::RETURN_SUCCESS;
    }
}
