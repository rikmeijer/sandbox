<?php
$url = "https://example.com/blabla";
if (parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST) == $url) {
    echo "host only";
} else {
    echo "more than that";
}