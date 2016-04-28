#!/usr/bin/php -q
<?php
/**
 * PHP shell script to play morse code through the speaker
 * 
 * Run this script from the command line and pass a message in quotes as 
 * an arguement to have it convert it to morse code and play it through 
 * the speakers.
 * 
 * If you simply want a script to convert a character to morse code look
 * at the function char2morse() and loop each character of a string to it.
 * However, most times we need to run the morse() function instead so that
 * the gaps between letters and words are generated.
 */ 

if (php_sapi_name() != 'cli' || isset($_SERVER['REMOTE_ADDR'])) {
    die('<b>Error:</b> This script is a shell script and is ment to be run from the command prompt.');
}

if (!isset($_SERVER['argv'][1])){
    die('Usage: '. $_SERVER['argv'][0] .' "MESSAGE"' ."\n");
}
else {
    morse($_SERVER['argv'][1]);
}

function char2morse($char){
    $code = array('A' => '.-',   'B' => '-...', 'C' => '-.-.', 'D' => '-..',
                  'E' => '.',    'F' => '..-.', 'G' => '--.',  'H' => '....',
                  'I' => '..',   'J' => '.---', 'K' => '-.-',  'L' => '.-..',
                  'M' => '--',   'N' => '-.',   'O' => '---',  'P' => '.--.',
                  'Q' => '--.-', 'R' => '.-.',  'S' => '...',  'T' => '-',
                  'U' => '..-',  'V' => '...-', 'W' => '.--',  'X' => '-..-',
                  'Y' => '-.--', 'Z' => '--..', '0' => '-----','1' => '.----',
                  '2' => '..---','3' => '...--','4' => '....-','5' => '.....',
                  '6' => '-....','7' => '--...','8' => '---..','9' => '----.',
                  '.' => '.-.-.-', ',' => '--..--','?' => '--..--', '!' => '-.-.--',
                  '\'' => '-..-.', '(' => '-.--.', ')' => '-.--.-', '&' => '.-...',
                  ':' => '---...', ';' => '-.-.-.','=' => '-...-',  '+' => '.-.-.',
                  '-' => '-....-', '_' => '..--.-','"' => '.-..-.', '$' => '...-..-',
                  '@' => '.--.-.');
    
    $char = strtoupper($char);
    
    if (array_key_exists($char, $code)) {
        return $code[$char]; 
    }
    else {
        return '';
    }
}           

function morse($message){
    $unit = 50;
    
    $words = explode(' ', $message);
    $word = 0;
    
    $encoded = NULL;

    echo $words[$word] .': ';
    for ($i = 0; $i < strlen($message); $i++) {
        if ($message{$i} == ' '){
            $word++;
            echo "\n". $words[$word] .': ';
            beep(0, ($unit * 7)); // medium gap (between words) — seven units long
        }
        else {
            $morse = char2morse($message{$i});
                
            for ($m = 0; $m < strlen($morse); $m++) {
                if ($morse{$m} == '.'){
                    echo '.'; 
                    beep(440, $unit); // short mark, dot or 'dit' (·) — 'dot duration' is one unit long
                }
                else { 
                    echo '-';
                    beep(440, ($unit * 3)); // longer mark, dash or 'dah' (–) — three units long
                }
                beep(0, $unit); // inter-element gap between the dots and dashes within a character — one dot duration or one unit long
            }
            
            echo ' ';
            beep(0, ($unit * 3)); // short gap (between letters) — three units long
        }
    }
    
    echo "\nSTOP\n";
    beep(440, $unit);
    beep(440, ($unit * 3));
    beep(440, $unit);
    beep(440, ($unit * 3));
    beep(440, $unit);
}

function beep($frequency, $duration){
    $duration   = $duration / 1000; // Second -> Millisecond
    $amplitude  = 127;
    $samplerate = 8000;

    $fp = fopen('/dev/dsp', 'w');
    
    for($i = 0; $i < ($duration * $samplerate); $i++) {
        $x = 128 + $amplitude * sin($i / $samplerate * $frequency * (2 * pi()));
        
        $x = chr($x);
        fwrite($fp, $x);
    }

    fclose($fp);
}

?>
