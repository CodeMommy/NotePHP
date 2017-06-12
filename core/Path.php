<?php

/**
 * @author Candison November <www.kandisheng.com>
 */

namespace Core;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Class Path
 * @package Core
 */
class Path
{
    /**
     * Remove First Slash
     *
     * @param $string
     */
    private static function removeFirstSlash(&$string)
    {
        if (substr($string, 0, 1) == '/') {
            $string = substr($string, 1);
        }
    }

    /**
     * Remove Last Slash
     *
     * @param $string
     */
    private static function removeLastSlash(&$string)
    {
        if (substr($string, -1) == '/') {
            $string = substr($string, 0, -1);
        }
    }

    /**
     * Replace Slash
     *
     * @param $string
     */
    private static function replaceSlash(&$string)
    {
        $string = str_replace('\\', '/', $string);
    }

    /**
     * Trim Path
     *
     * @param $path
     */
    private static function trimPath(&$path)
    {
        self::replaceSlash($path);
        self::removeFirstSlash($path);
        self::removeLastSlash($path);
    }

    /**
     * Application
     *
     * @param string $path
     *
     * @return string
     */
    public static function application($path = '')
    {
        self::trimPath($path);
        return sprintf('%s/../%s', __DIR__, $path);
    }

    /**
     * User
     *
     * @param string $path
     *
     * @return string
     */
    public static function user($path = '')
    {
        self::trimPath($path);
        return sprintf('./%s', $path);
    }

    /**
     * Copy Directory
     *
     * @param $source
     * @param $target
     */
    public static function copyDirectory($source, $target)
    {
        $fileSystem = new Filesystem();
        $directory = dir($source);
        $fileSystem->mkdir($target);
        while (($item = $directory->read()) !== false) {
            if (in_array($item, array('.', '..'))) {
                continue;
            }
            $sourceFile = sprintf('%s/%s', $source, $item);
            $targetFile = sprintf('%s/%s', $target, $item);
            if (is_dir($sourceFile)) {
                self::copyDirectory($sourceFile, $targetFile);
                continue;
            }
            $fileSystem->copy($sourceFile, $targetFile);
        }
        $directory->close();
    }

    /**
     * Is Directory Empty
     *
     * @param $path
     *
     * @return bool
     */
    public static function isDirectoryEmpty($path)
    {
        if (!is_dir($path)) {
            return false;
        }
        $directory = dir($path);
        while (($item = $directory->read()) !== false) {
            if (!in_array($item, array('.', '..'))) {
                return false;
            }
        }
        $directory->close();
        return true;
    }
}