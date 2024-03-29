<?php

namespace Physler;

use DateTime;

/**
 * Simple alias for nl2br -> echo
 *
 * @param string $input
 * @return void
 */
function nout($input) {
    echo( nl2br($input) );
}

/**
 * Handle placeholder tags in content.
 *
 * @param string $content
 * @param array $placeholder_array
 * @return string
 */
function HandlePlaceholders($content, $placeholder_array) {
    for ($i=0; $i < COUNT( $placeholder_array ); $i++) { 
        $content = str_replace("%:".$placeholder_array[$i][0], $placeholder_array[$i][1], $content);
    }

    return $content;
}

/**
 * Convert unix timestamp to an elapsed time string
 *
 * @param string|int $datetime
 * @param boolean $full
 * @return string
 */
function StrTimeElapsed($datetime, $full = false) {
    if ($datetime == 0) {return "never";}
    $now = new DateTime("@".time());
    $ago = new DateTime("@".(string)$datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

/**
 * Check for any requests to hang the application
 *
 * @return boolean
 */
function is_app_hang() {
    return !(isset($_GET["hang"]) && $_GET["hang"] == "1");
}

function do_splash_animation() {
    return (isset($_GET["anim"]) && $_GET["anim"] == "1");
}