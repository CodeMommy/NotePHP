<?php

/**
 * @author Candison November <www.kandisheng.com>
 */

namespace Core;

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
}