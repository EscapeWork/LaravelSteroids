<?php

if (! function_exists('create_links')) {
    function create_links($text) {
        return preg_replace('/(http[s]{0,1}\:\/\/\S{4,})\s{0,}/ims', '<a href="$1" target="_blank">$1</a> ', $text);
    }
}
