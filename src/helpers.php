<?php

if (! function_exists('create_links')) {
    function create_links($text) {
        return preg_replace('!(http://[a-z0-9_./?=&-]+)!i', '<a href="$1">$1</a> ', $text." ");
    }
}
