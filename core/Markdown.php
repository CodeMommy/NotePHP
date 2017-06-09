<?php

/**
 * @author Candison November <www.kandisheng.com>
 */

namespace Core;

use League\CommonMark\CommonMarkConverter;

/**
 * Class Markdown
 * @package Core
 */
class Markdown
{
    /**
     * To HTML
     *
     * @param $markdown
     *
     * @return string
     */
    public static function toHTML($markdown)
    {
        $converter = new CommonMarkConverter();
        return $converter->convertToHtml($markdown);
    }
}