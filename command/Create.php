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
 * Class Create
 * @package Command
 */
class Create extends Command
{
    /**
     * Configure
     */
    protected function configure()
    {
        $this->setName('create');
        $this->setDescription('Create New Project');
        $this->setHelp('Create New Project');
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
        $fileSystem = new Filesystem();
        if ($fileSystem->exists($localFolder)) {
            if (!is_dir($localFolder)) {
                return Message::error($output, sprintf('"%s" is not a folder.', $localFolder));
            }
            if (!Path::isDirectoryEmpty($localFolder)) {
                return Message::error($output, sprintf('Folder "%s" is not empty.', $localFolder));
            }
        }
        Path::copyDirectory(Path::application('base'), $localFolder);
        return Message::information($output, sprintf('Project created at "%s".', $localFolder));
    }
}