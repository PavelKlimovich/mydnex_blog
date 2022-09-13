<?php 

namespace Src\Helpers;

class Str
{

    /**
     * Convert string to slug.
     *
     * @param string $text
     * @param string $divider
     * @return string
     */
    public static function slugify(string $text, string $divider = '-'): string
    {
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, $divider);
        $text = preg_replace('~-+~', $divider, $text);
        $text = strtolower($text);

        return $text;
    }
}