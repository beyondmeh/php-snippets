<?php

function base58_encode($num) {
    $alphabet = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
    $base = strlen($alphabet);
    $encoded = '';

    while ($num >= $base) {
        $mod = $num % $base;
        $encoded = $alphabet[$mod] . $encoded;
        $num = floor($num / $base);
    }

    if ($num) $encoded = $alphabet[intval($num)] . $encoded;

    return $encoded;
}

function base58_decode($num) {
    $alphabet = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
    $base = strlen($alphabet);
    $len = strlen($num);
    $decoded = 0;
    $multi = 1;

    for ($i = $len - 1; $i >= 0; $i--) {
        $decoded += $multi * strpos($alphabet, $num[$i]);
        $multi = $multi * $base;
    }

    return $decoded;
}

?>
