<?php

namespace Zoop\Common;

class Slugger
{
    public static function createSlug($text, $delimeter = '-')
    {
        return trim(
            preg_replace(
                '~[^-\w]+~',
                '',
                strtolower(
                    iconv(
                        'utf-8',
                        'ascii//TRANSLIT',
                        trim(
                            preg_replace(
                                '~[^\\pL\d]+~u',
                                $delimeter,
                                $text
                            ),
                            '-'
                        )
                    )
                )
            ),
            '-'
        );
    }
}
