<?php
/* http://tools.ietf.org/html/rfc6238
 * http://tools.ietf.org/html/rfc4226
 * https://www.idontplaydarts.com/2011/07/google-totp-two-factor-authentication-for-php/
 * http://online-calculators.appspot.com/base32/
 *
 * Todo:
 *   Encode secret as base32
 *   Generate random base32 with padding char =
 *   https://github.com/yurri/GoogleAuthenticatorClient/blob/master/classes/Base32.php
 */

    $issuer    = '';
    $id        = '';

    $secret    = 'DEADBEEFD3ADB33F';

    $type      = 'totp'; // TOTP: Time-based, HOTP: counter-based
    $algorithm = 'sha1'; // sha1, sha256, sha512, md5
    $interval  = 30;     // Number of seconds between token changes
    $digits    = 6;      // 6 or 8

// --- TESTING ---------------------------------------------------------

// for ($i=0; $i < 10; $i++) echo random_base32() . '<br>';

$key     = base32_decode($secret);
$counter = epoch_interval($interval);

echo '<strong>Secret:</strong> ' . $secret . '<br>';
echo '<strong>Binary Key:</strong> ' . $key . '<br>';
echo '<strong>Interval:</strong> ' . $counter . '<br>';

echo '<hr><h2>SHA-1</h2>';

$sha1_hash   = oauth_hotp($key, $counter);
$otp_sha1_d6 = oauth_truncate($sha1_hash, 6);
$otp_sha1_d8 = oauth_truncate($sha1_hash, 8);

echo '<strong>Binary Hash:</strong> ' . $sha1_hash . '<br>';
echo '<strong>6D OTP:</strong> ' . $otp_sha1_d6 . '<br>';
echo '<strong>8D OTP:</strong> ' . $otp_sha1_d8 . '<br>';

echo '<hr><h2>MD5</h2>';

$md5_hash   = oauth_hotp($key, $counter, 'md5');
$otp_md5_d6 = oauth_truncate($md5_hash, 6);
$otp_md5_d8 = oauth_truncate($md5_hash, 8);

echo '<strong>Binary Hash:</strong> ' . $md5_hash . '<br>';
echo '<strong>6D OTP:</strong> ' . $otp_md5_d6 . '<br>';
echo '<strong>8D OTP:</strong> ' . $otp_md5_d8 . '<br>';

echo '<h1><h2>SHA-256</h2>';

$sha256_hash   = oauth_hotp($key, $counter, 'sha256');
$otp_sha256_d6 = oauth_truncate($sha256_hash, 6);
$otp_sha256_d8 = oauth_truncate($sha256_hash, 8);

echo '<strong>Binary Hash:</strong> ' . $sha256_hash . '<br>';
echo '<strong>SHA1 6D OTP:</strong> ' . $otp_sha256_d6 . '<br>';
echo '<strong>SHA1 8D OTP:</strong> ' . $otp_sha256_d8 . '<br>';

echo '<hr><h2>SHA-512</h2>';

$sha512_hash   = oauth_hotp($key, $counter, 'sha512');
$otp_sha512_d6 = oauth_truncate($sha512_hash, 6);
$otp_sha512_d8 = oauth_truncate($sha512_hash, 8);

echo '<strong>Binary Hash:</strong> ' . $sha512_hash . '<br>';
echo '<strong>SHA1 6D OTP:</strong> ' . $otp_sha512_d6 . '<br>';
echo '<strong>SHA1 8D OTP:</strong> ' . $otp_sha512_d8 . '<br>';

// --- FUNCTIONS -------------------------------------------------------

function oauth_hotp($key, $counter, $algorithm = 'sha1'){
    $counter = pack('N*', 0) . pack('N*', $counter);

    $hash = hash_hmac($algorithm, $counter, $key, TRUE);

    return $hash;
}

function oauth_truncate($hash, $length = 6){

    $offset = mb_strlen($hash, '8bit') - 1;
    $offset = ord($hash[$offset]) & 0xf;

    $otp  = (
             ((ord($hash[$offset+0]) & 0x7f) << 24 ) |
             ((ord($hash[$offset+1]) & 0xff) << 16 ) |
             ((ord($hash[$offset+2]) & 0xff) << 8 ) |
             (ord($hash[$offset+3]) & 0xff)
            ) % pow(10, $length);

    return str_pad($otp, $length, '0', STR_PAD_LEFT);
}

function epoch_interval($interval = 30, $time = NULL){
    if ($time === NULL) $time = microtime(TRUE);

    return floor($time / $interval);
}

function base32_decode($base32){
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    $base32 = strtoupper($base32);

    $decoded = '';

    foreach (str_split($base32) as $char) {
        $number = strpos($chars, $char);

        if ($number === FALSE) $number = 0;

        $decoded .= sprintf('%05b', $number);
    }

    $args = array_map('bindec', str_split($decoded, 8));
    array_unshift($args, 'C*');

    return rtrim(call_user_func_array('pack', $args), "\0");
}

function random_base32($length = 16){
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    $random = '';

    for ($i = 0; $i < $length; $i++){
        $random .= $chars[rand_secure(0, strlen($chars))];
    }

    return $random;
}

function rand_secure($min, $max) {
    /* christophe dot weis at statec dot etat dot lu
     * http://php.net/manual/en/function.openssl-random-pseudo-bytes.php
     */

    $range = $max - $min;

    if ($range == 0) return $min; // not so random...

    $log = log($range, 2);
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1

    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes, $s)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } 
    while ($rnd >= $range);

    return $min + $rnd;
}

?>
