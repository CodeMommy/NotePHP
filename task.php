<?php

/**
 * @author Candison November <www.kandisheng.com>
 */

require_once(__DIR__ . '/vendor/autoload.php');

use CodeMommy\TaskPHP\Task;
use Symfony\Component\Filesystem\Filesystem;
use Core\Path;

/**
 * Task Update
 */
function taskUpdate()
{
    system('php -v');
    Task::line();
    system('git pull');
    Task::line();
    system('composer self-update');
    Task::line();
    system('composer update');
}

Task::add('update', 'Update Composer', 'taskUpdate');

/**
 * Task Update Version
 */
function taskUpdateVersion()
{
    $file = __DIR__ . '/composer.json';
    $composer = file_get_contents($file);
    $composer = json_decode($composer, true);
    $version = $composer['version'];
    $version = explode('.', $version);
    $version[2] = intval($version[2]) + 1;
    $version = implode('.', $version);
    $composer['version'] = $version;
    $composer = json_encode($composer, JSON_PRETTY_PRINT);
    $composer = str_replace('\\/', '/', $composer);
    file_put_contents($file, $composer);
    echo(sprintf('Updated version to %s.', $version));
}

Task::add('update-version', 'Update Version', 'taskUpdateVersion');

/**
 * Task Clear
 */
function taskClear()
{
    $removeList = array();
    array_push($removeList, __DIR__ . '/application/_runtime');
    $fileSystem = new Filesystem();
    foreach ($removeList as $value) {
        $fileSystem->remove($value);
    }
    echo(sprintf('Clear Finished.'));
}

Task::add('clear', 'Clear', 'taskClear');

function copyDirectory($source, $target)
{
    $fileSystem = new Filesystem();
    $directory = dir($source);
    $fileSystem->mkdir($target);
    while (($item = $directory->read()) !== false) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (is_dir($source . '/' . $item)) {
            copyDirectory($source . '/' . $item, $target . '/' . $item);
            continue;
        } else {
            $fileSystem->copy($source . '/' . $item, $target . '/' . $item);
        }
    }
    $directory->close();
}

/**
 * Task Publish
 */
function taskPublish()
{
    // Composer
    $composerFile = Path::application('composer.json');
    $composerContent = file_get_contents($composerFile);
    $composer = json_decode($composerContent, true);
    $applicationName = isset($composer['title']) ? $composer['title'] : '';
    $applicationVersion = isset($composer['version']) ? $composer['version'] : '';
    // Config
    $pharTarget = Path::application('.publish');
    $pharSource = Path::application('.temporary');
    $pharIndex = 'application.php';
    $pharWebIndex = 'application.php';
    $pharName = sprintf('%s.phar', $applicationName);
    $pharFileName = sprintf('%s_%s.phar', $applicationName, $applicationVersion);
    $pharFilePath = sprintf('%s/%s', $pharTarget, $pharFileName);
    // Prepare
    $fileSystem = new Filesystem();
    $fileSystem->remove($pharSource);
    $fileSystem->mkdir($pharSource);
    $fileSystem->mkdir($pharTarget);
    $copyList = array('command', 'core', 'vendor', 'application.php', 'composer.json');
    foreach ($copyList as $value) {
        $sourceFile = sprintf('%s/%s', __DIR__, $value);
        $targetFile = sprintf('%s/%s', $pharSource, $value);
        if (is_dir($sourceFile)) {
            copyDirectory($sourceFile, $targetFile);
        }
        if (is_file($sourceFile)) {
            $fileSystem->copy($sourceFile, $targetFile);
        }
    }
    // Run
    $phar = new Phar($pharFilePath, 0, $pharName);
    $phar->buildFromDirectory($pharSource);
    $phar->setStub($phar->createDefaultStub($pharIndex, $pharWebIndex));
    $phar->compressFiles(Phar::GZ);
    // Clean
    $fileSystem->copy(sprintf('%s/%s', $pharTarget, $pharFileName), sprintf('%s/%s', $pharTarget, $pharName));
    $fileSystem->remove($pharSource);
}

Task::add('publish', 'Publish', 'taskPublish');

/**
 * Start
 */
Task::config('NotePHP Task', '');
Task::run();