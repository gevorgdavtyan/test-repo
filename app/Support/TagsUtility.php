<?php

namespace App\Support;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TagsUtility
{
    /**
     * @param $text
     * @return array
     */
    public static function convert_tags_string_to_array($text)
    {
        return array_filter(
            array_map(
                'trim',
                preg_split("/[,]/", $text)
            )
        );
    }
}
