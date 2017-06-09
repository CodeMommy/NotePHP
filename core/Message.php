<?php

/**
 * @author Candison November <www.kandisheng.com>
 */

namespace Core;

/**
 * Class Message
 * @package Core
 */
class Message
{
    /**
     * Show
     *
     * @param $output
     * @param string $message
     *
     * @return null
     */
    public static function show($output, $message = '')
    {
        $output->writeln($message);
        return null;
    }

    /**
     * Error
     *
     * @param $output
     * @param string $message
     *
     * @return null
     */
    public static function error($output, $message = '')
    {
        $output->writeln(sprintf('<error>%s</error>', $message));
        return null;
    }

    /**
     * Question
     *
     * @param $output
     * @param string $message
     *
     * @return null
     */
    public static function question($output, $message = '')
    {
        $output->writeln(sprintf('<question>%s</question>', $message));
        return null;
    }

    /**
     * Comment
     *
     * @param $output
     * @param string $message
     *
     * @return null
     */
    public static function comment($output, $message = '')
    {
        $output->writeln(sprintf('<comment>%s</comment>', $message));
        return null;
    }

    /**
     * Information
     *
     * @param $output
     * @param string $message
     *
     * @return null
     */
    public static function information($output, $message = '')
    {
        $output->writeln(sprintf('<info>%s</info>', $message));
        return null;
    }
}