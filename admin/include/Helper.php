<?php
/**
 * Created by PhpStorm.
 * User: johnpaulgabule
 * Date: 2/9/2018
 * Time: 9:32 PM
 */
function redirect_to($location) {
    header("Location: {$location}");
}

function clean($string) {
    return htmlentities(strip_tags(trim($string)));
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
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

function trim_body($text, $max_length = 30, $tail = '...') {

    $tail_len = strlen($tail);

    if (strlen($text) >  $max_length) {

        $tmp_text = substr($text, 0, $max_length - $tail_len);

        if (substr($text, $max_length - $tail_len, 1) == ' ') {

            $text = $tmp_text;

        } else {

            $pos = strrpos($tmp_text, ' ');

            $text = substr($text, 0, $pos);

        }

        $text = $text . $tail;

    }

    return $text;
}

function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('', 'K', 'MB', 'GB', 'TB');   

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}
