<?php

if (! function_exists('create_links')) {
    function create_links($text) {
        $text = preg_replace("#(^|[\n ])@([^ \"\t\n\r<]*)#ise", "'\\1<a target=\"_blank\" href=\"http://www.twitter.com/\\2\" >@\\2</a>'", $text);
        $text = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", "'\\1<a target=\"_blank\" href=\"\\2\" rel=\"nofollow\">\\2</a>'", $text);
        $text = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#ise", "'\\1<a target=\"_blank\" href=\"http://\\2\" rel=\"nofollow\">\\2</a>'", $text);

        return $text;
    }
}
