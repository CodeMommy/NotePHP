<?php

/**
 * @author Candison November <www.kandisheng.com>
 */

namespace Command;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Filesystem\Filesystem;
use Core\Message;
use Core\Path;

/**
 * Class Publish
 * @package Command
 */
class Publish extends Command
{
    /**
     * Configure
     */
    protected function configure()
    {
        $this->setName('publish');
        $this->setDescription('Publish the project');
        $this->setHelp('Publish the project');
        $this->addArgument('folder', InputArgument::OPTIONAL, 'Folder');
    }

    /**
     * Execute
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $folder = $input->hasArgument('folder') ? $input->getArgument('folder') : '';
        $localFolder = Path::user($folder);
    }
}