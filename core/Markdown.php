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