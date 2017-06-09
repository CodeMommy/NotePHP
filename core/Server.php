<?php

/**
 * @author Candison November <www.kandisheng.com>
 */

namespace Core;

use Symfony\Component\Console\Application;

/**
 * Class Server
 * @package Core
 */
class Server
{
    /**
     * Start
     */
    public static function start()
    {
        // Get Information
        $composerFile = Path::application('composer.json');
        $composerContent = file_get_contents($composerFile);
        $composer = json_decode($composerContent, true);
        $applicationName = isset($composer['title']) ? $composer['title'] : '';
        $applicationVersion = isset($composer['version']) ? $composer['version'] : '';
        $application = new Application($applicationName, $applicationVersion);
        // Register Command
        $path = Path::application('command');
        $directory = dir($path);
        while (($file = $directory->read()) !== false) {
            $filePath = sprintf('%s/%s', $path, $file);
            if (is_file($filePath)) {
                $commandName = substr($file, 0, -4);
                $nameSpace = sprintf('\\Command\\%s', $commandName);
                $application->add(new $nameSpace());
            }
        }
        $directory->close();
        // Run
        $application->run();
    }
}