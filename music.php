#!/usr/bin/php -q
<?php
<?php
/**
 * PHP shell script to play music
 * 
 * Run this script from the command line and pass a song title as an 
 * arguement to have it play through the speakers. The "music" is nothing 
 * more than a string of frequencies and durations that is parsed as 
 * individual 'beeps'. Beyond the fun proof of concept there are some 
 * useful functions. 
 * 
 * Beep is much like Microsoft Window's beep() API except it uses Linux's
 * DSP... if you don't have that look for alsa-oss or change the relevant 
 * line to /dev/audio 
 * 
 * note() computes the frequency of a piano key given it's distance from 
 * middle C. For example, A would be -2 and F would be 5. You
 * can go up and down multiple octaves too... just add or subtract 8 from 
 * the note you want.
 * 
 * @author     Timothy Keith <timothy@keithieopia.com>
 * @copyright  2011 Timothy Keith
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       https://github.com/keithieopia/snippets
 */ 
 
if (php_sapi_name() != 'cli' || isset($_SERVER['REMOTE_ADDR'])) {
	die('<b>Error:</b> This script is a shell script and is ment to be run from the command prompt.');
}

if (!isset($_SERVER['argv'][1])) $_SERVER['argv'][1] = NULL;


switch ($_SERVER['argv'][1]){
	case 'scale':
		for ($i = 0; $i < 8; $i++){
			$freq = note(440, $i);
	
			echo $freq . "\n";
			beep($freq, 500);
		}
		break;
	case 'crazytrain':
		parseMusicStr('195.998,200|195.998,200|293.665,200|195.998,200|311.127,200|195.998,200|293.665,200|195.998,200|R,10|261.626,200|233.082,200|220.000,200|233.082,200|261.626,200|233.082,200|220.000,200|174.614,200|195.998,200|195.998,200|293.665,200|195.998,200|311.127,200|195.998,200|293.665,200|195.998,200|R,10|261.626,200|233.082,200|220.000,200|233.082,200|261.626,200|233.082,200|220.000,200|174.614,200|195.998,200|195.998,200|293.665,200|195.998,200|311.127,200|195.998,200|293.665,200|195.998,200|R,10|261.626,200|233.082,200|220.000,200|233.082,200|261.626,200|233.082,200|220.000,200|174.614,200');
		break;
	case 'clocks':
		parseMusicStr('1318.51,200|987.767,200|830.609,200|R,10|1318.51,200|987.767,200|830.609,200|R,10|1318.51,200|987.767,200|R,10|1174.66,200|987.767,200|739.989,200|R,10|1174.66,200|987.767,200|739.989,200|R,10|1174.66,200|987.767,200|R,10|1174.66,200|987.767,200|739.989,200|R,10|1174.66,200|987.767,200|739.989,200|R,10|1174.66,200|987.767,200|R,10|1108.73,200|880.000,200|739.989,200|R,10|1108.73,200|880.000,200|739.989,200|R,10|1108.73,200|880.000,200|1318.51,200|987.767,200|830.609,200|R,10|1318.51,200|987.767,200|830.609,200|R,10|1318.51,200|987.767,200|R,10|1174.66,200|987.767,200|739.989,200|R,10|1174.66,200|987.767,200|739.989,200|R,10|1174.66,200|987.767,200|R,10|1174.66,200|987.767,200|739.989,200|R,10|1174.66,200|987.767,200|739.989,200|R,10|1174.66,200|987.767,200|R,10|1108.73,200|880.000,200|739.989,200|R,10|1108.73,200|880.000,200|739.989,200|R,10|1108.73,200|880.000,200|1318.51,200|987.767,200|830.609,200|R,10|1318.51,200|987.767,200|830.609,200|R,10|1318.51,200|987.767,200|R,10|1174.66,200|987.767,200|739.989,200|R,10|1174.66,200|987.767,200|739.989,200|R,10|1174.66,200|987.767,200|R,10|1174.66,200|987.767,200|739.989,200|R,10|1174.66,200|987.767,200|739.989,200|R,10|1174.66,200|987.767,200|R,10|1108.73,200|880.000,200|739.989,200|R,10|1108.73,200|880.000,200|739.989,200|R,10|1108.73,200|880.000,200');
		break;
	case 'mario':
		parseMusicStr('311.127,300|349.228,300|391.995,300|415.305,300|466.164,300|493.883,300|523.251,150|523.251,150|523.251,150|R,150|523.251,150|R,150|523.251,600|415.305,300|698.456,900|659.255,900|698.456,900|R,150|415.305,150|466.164,150|523.251,150|554.365,150|622.254,150|698.456,900|659.255,600|739.989,300|698.456,900|R,750|415.305,150|622.254,900|587.330,900|622.254,900|R,150|415.305,150|466.164,150|523.251,150|554.365,150|587.330,150|622.254,900|415.305,600|739.989,300|698.456,900|R,750|415.305,150|830.609,900|830.609,900|830.609,900|830.609,300|932.328,150|R,300|830.609,150|739.989,900|739.989,900|739.989,900|739.989,300|830.609,150|R,300|739.989,150|698.456,900|466.164,300|523.251,300|739.989,300|698.456,150|698.456,150|698.456,450|523.251,150|554.365,900');
		break;
	case 'empire':
		parseMusicStr('554.365,700|554.365,700|554.365,700|440.000,700|659.255,250|554.365,700|440.000,700|659.255,150|554.365,1200|830.609,700|830.609,700|830.609,700|880.000,700|622.254,150|523.251,700|440.000,700|659.255,150|554.365,700|1108.73,700|554.365,500|554.365,200|1108.73,700|1046.50,500|987.767,200|932.328,200|880.000,200|932.328,500|R,250|554.365,500|739.989,700|698.456,700|659.255,700|622.254,350|587.330,250|622.254,700|R,250|415.305,700|493.883,400|415.305,250|R,100|415.305,250|659.255,400|554.365,700|440.000,500|659.255,200|554.365,1500');
		break;
	case 'stillalive':
		parseMusicStr('391.995,250|369.994,250|329.628,250|329.628,250|369.994,250|R,1000|R,500|R,250|220.000,250|391.995,250|369.994,250|329.628,250|329.628,500|369.994,750|293.665,500|329.628,250|220.000,250|220.000,1500|R,250|220.000,250|329.628,500|369.994,250|391.995,500|329.628,250|277.183,500|293.665,750|329.628,500|220.000,250|220.000,500|369.994,2000|R,1000|391.995,250|369.994,250|329.628,250|329.628,250|369.994,250|R,1000|R,500|R,250|220.000,250|391.995,250|369.994,250|329.628,250|329.628,500|369.994,750|293.665,500|329.628,250|220.000,750|R,500|R,1000|329.628,500|369.994,250|391.995,750|329.628,250|277.183,750|293.665,250|329.628,500|220.000,250|293.665,250|329.628,250|349.228,250|329.628,250|293.665,250|261.626,250|R,500|220.000,250|233.082,250|261.626,500|349.228,500|329.628,250|293.665,250|293.665,250|261.626,250|293.665,250|261.626,250|261.626,500|261.626,500|220.000,250|233.082,250|261.626,500|349.228,500|391.995,250|349.228,250|329.628,250|293.665,250|293.665,250|329.628,250|349.228,500|349.228,500|391.995,250|440.000,250|466.164,250|466.164,250|440.000,500|391.995,500|349.228,250|391.995,250|440.000,250|440.000,250|391.995,500|349.228,500|293.665,250|261.626,250|293.665,250|349.228,250|349.228,250|329.628,500|329.628,250|369.994,250|369.994,1000');
		break;
	case 'deckhalls':
		parseMusicStr('830.609,400|739.989,200|698.456,300|622.254,300|554.365,300|622.254,300|698.456,300|554.365,300|R,50|622.254,150|698.456,150|739.989,150|622.254,150|698.456,400|R,50|622.254,200|554.365,300|523.251,300|554.365,500|R,100|830.609,400|739.989,200|698.456,300|622.254,300|554.365,300|622.254,300|698.456,300|554.365,300|R,50|622.254,150|698.456,150|739.989,150|622.254,150|698.456,400|R,50|622.254,200|554.365,300|523.251,300|554.365,500|R,100|622.254,400|698.456,200|739.989,300|622.254,250|698.456,400|739.989,200|830.609,300|698.456,200|R,50|698.456,200|783.991,200|830.609,300|R,25|932.328,150|1046.50,200|1108.73,300|R,25|1046.50,300|932.328,300|830.609,300|R,200|830.609,400|739.989,200|698.456,300|622.254,300|554.365,300|622.254,300|698.456,300|554.365,300|932.328,150|932.328,200|932.328,200|932.328,200|830.609,500|R,100|739.989,300|698.456,400|622.254,400|554.365,1000');
		break;
	case 'entertainer':
		parseMusicStr('1244.51,200|1396.91,200|1108.73,200|932.328,200|R,100|1046.50,200|830.609,200|R,200|622.254,200|698.456,200|554.365,200|466.164,200|R,100|523.251,200|415.305,200|R,200|311.127,200|349.228,200|277.183,200|233.082,300|R,100|261.626,200|233.082,200|220.000,200|207.652,200|R,600|830.609,200|R,500|622.254,200|659.255,200|698.456,200|1108.73,300|R,100|698.456,200|1108.73,300|R,100|698.456,200|1108.73,500|R,100|1108.73,200|1244.51,200|1318.51,200|1396.91,250|R,10|1108.73,200|1244.51,200|1396.91,250|R,10|1046.50,200|1244.51,250|1108.73,300');
		break;
	case 'ffvictory':
		parseMusicStr('784,100|784,100|784,100|R,100|784,600|622,600|698,600|784,200|R,200|698,200|784,800');
		break;
	case 'pinkpanther':
		parseMusicStr('209,200|220,400|R,200|247,200|262,400|R,200|209,200|220,400|R,80|247,200|262,400|R,80|349,200|330,400|R,80|200,200|262,400|R,80|330,200|311,600');
		break;
	case 'gentlemen':
		parseMusicStr('277.183,300|277.183,375|415.305,300|415.305,300|369.994,300|329.628,300|311.127,300|277.183,300|246.942,300|277.183,300|311.127,300|329.628,300|369.994,300|415.305,750|277.183,300|277.183,375|415.305,300|415.305,300|369.994,300|329.628,300|311.127,300|277.183,300|246.942,300|277.183,300|311.127,300|329.628,300|369.994,300|415.305,750|R,20|415.305,300|440.000,300|369.994,300|415.305,300|440.000,300|493.883,300|554.365,300|415.305,300|369.994,300|329.628,300|277.183,300|311.127,300|329.628,300|369.994,500|R,20|329.628,300|369.994,300|415.305,500|440.000,300|415.305,300|415.305,300|369.994,300|329.628,300|311.127,300|277.183,500|329.628,200|311.127,200|277.183,200|369.994,500|R,20|329.628,300|369.994,300|415.305,300|440.000,300|493.883,300|554.365,300|415.305,300|369.994,300|329.628,300|311.127,300|277.183,1250');
		break;
	case 'moveit':
		parseMusicStr('587.330,400|R,50|587.330,400|R,50|587.330,400|R,50|587.330,200|R,20|880.000,300|R,400|587.330,400|R,50|587.330,400|R,50|587.330,400|R,50|587.330,200|R,20|880.000,300|R,400|587.330,400|R,50|587.330,400|R,50|587.330,400|R,50|587.330,200|R,20|880.000,300|R,400|587.330,400|R,10|587.330,400|R,10|587.330,400|R,10|587.330,200|R,10|880.000,200|R,10|698.456,400|R,10|698.456,400|R,10|659.255,200|R,10|698.456,200|R,10|659.255,200|R,10|880.000,200|R,10|587.330,400|R,10|587.330,400|R,10|587.330,400|R,10|587.330,200|R,10|880.000,200|R,10|698.456,400|R,10|698.456,400|R,10|659.255,200|R,10|698.456,200|R,10|659.255,200|R,10|880.000,200|R,10|587.330,400|R,10|587.330,400|R,10|587.330,400|R,10|587.330,200|R,10|880.000,200|R,10|698.456,400|R,10|698.456,400|R,10|659.255,200|R,10|698.456,200|R,10|659.255,200|R,10|880.000,200|R,10|659.255,400|R,10|659.255,400|R,10|659.255,400|R,10|659.255,200|R,10|987.767,200|R,10|783.991,400|R,10|783.991,400|R,10|739.989,200|R,10|783.991,200|R,10|739.989,200|R,10|987.767,200|R,10|659.255,400|R,10|659.255,400|R,10|659.255,400|R,10|659.255,200|R,10|987.767,200|R,10|783.991,400|R,10|783.991,400|R,10|739.989,200|R,10|783.991,200|R,10|739.989,200|R,10|987.767,200|R,10|659.255,400|R,10|659.255,400|R,10|659.255,400|R,10|659.255,200|R,10|987.767,200|R,10|783.991,400|R,10|783.991,400|R,10|739.989,200|R,10|783.991,200|R,10|739.989,200|R,10|987.767,200|R,10|659.255,400|R,10|659.255,400|R,10|659.255,400|R,10|659.255,200|R,10|987.767,200|R,10|783.991,400|R,10|783.991,400|R,10|739.989,200|R,10|783.991,200|R,10|739.989,200|R,10|987.767,200|R,10|659.255,400|R,10|659.255,400|R,10|659.255,400|R,10|659.255,200|R,10|987.767,200|R,10|783.991,400|R,10|783.991,400|R,10|739.989,200|R,10|783.991,200|R,10|739.989,200|R,10|987.767,200|R,10|659.255,400|R,10|659.255,400|R,10|659.255,400|R,10|659.255,200|R,10|987.767,200|R,10|783.991,400|R,10|783.991,400|R,10|739.989,200|R,10|783.991,200|R,10|739.989,200|R,10|987.767,200|R,10|659.255,400|R,10|659.255,400|R,10|659.255,400|R,10|659.255,200|R,10|987.767,200|R,10|783.991,400|R,10|783.991,400|R,10|739.989,200|R,10|783.991,200|R,10|739.989,200|R,10|987.767,200|R,10|523.251,400|R,10|523.251,400|R,10|523.251,400|R,10|523.251,200|R,10|783.991,200|R,10|622.254,400|R,10|622.254,400|R,10|587.330,200|R,10|622.254,200|R,10|587.330,200|R,10|783.991,200|R,10|587.330,400|R,10|587.330,400|R,10|587.330,400|R,10|587.330,200|R,10|880.000,200|R,10|698.456,400|R,10|698.456,400|R,10|659.255,200|R,10|698.456,200|R,10|659.255,200|R,10|880.000,200');
		break;
	case 'bumblebee':
		parseMusicStr('1396.91,93.75|1318.51,93.75|1244.51,93.75|1174.66,93.75|1244.51,93.75|1174.66,93.75|1108.73,93.75|1046.50,93.75|1108.73,93.75|1046.50,93.75|987.767,93.75|932.328,93.75|880.000,93.75|830.609,93.75|783.991,93.75|739.989,93.75|698.456,93.75|659.255,93.75|622.254,93.75|587.330,93.75|622.254,93.75|587.330,93.75|554.365,93.75|523.251,93.75|554.365,93.75|523.251,93.75|493.883,93.75|466.164,93.75|440.000,93.75|415.305,93.75|391.995,93.75|369.994,93.75|349.228,93.75|329.628,93.75|311.127,93.75|293.665,93.75|311.127,93.75|293.665,93.75|277.183,93.75|261.626,93.75|349.228,93.75|329.628,93.75|311.127,93.75|293.665,93.75|311.127,93.75|293.665,93.75|277.183,93.75|261.626,93.75|349.228,93.75|329.628,93.75|311.127,93.75|293.665,93.75|277.183,93.75|369.994,93.75|349.228,93.75|329.628,93.75|349.228,93.75|329.628,93.75|311.127,93.75|293.665,93.75|277.183,93.75|293.665,93.75|311.127,93.75|329.628,93.75|349.228,93.75|329.628,93.75|311.127,93.75|293.665,93.75|277.183,93.75|369.994,93.75|349.228,93.75|329.628,93.75|349.228,93.75|329.628,93.75|311.127,93.75|293.665,93.75|277.183,93.75|293.665,93.75|311.127,93.75|329.628,93.75|349.228,93.75|329.628,93.75|311.127,93.75|293.665,93.75|311.127,93.75|293.665,93.75|277.183,93.75|261.626,93.75|277.183,93.75|293.665,93.75|311.127,93.75|329.628,93.75|349.228,93.75|369.994,93.75|349.228,93.75|311.127,93.75|349.228,93.75|329.628,93.75|311.127,93.75|293.665,93.75|311.127,93.75|293.665,93.75|277.183,93.75|261.626,93.75|277.183,93.75|293.665,93.75|311.127,93.75|329.628,93.75|349.228,93.75|391.995,93.75|415.305,93.75|440.000,93.75|466.164,93.75|440.000,93.75|415.305,93.75|391.995,93.75|369.994,93.75|493.883,93.75|466.164,93.75|440.000,93.75|466.164,93.75|440.000,93.75|415.305,93.75|391.995,93.75|369.994,93.75|391.995,93.75|415.305,93.75|440.000,93.75|466.164,93.75|440.000,93.75|415.305,93.75|391.995,93.75|369.994,93.75|493.883,93.75|466.164,93.75|440.000,93.75|466.164,93.75|440.000,93.75|415.305,93.75|391.995,93.75|369.994,93.75|391.995,93.75|415.305,93.75|440.000,93.75|466.164,93.75|440.000,93.75|415.305,93.75|391.995,93.75|415.305,93.75|391.995,93.75|369.994,93.75|349.228,93.75|369.994,93.75|391.995,93.75|415.305,93.75|440.000,93.75|466.164,93.75|493.883,93.75|466.164,93.75|440.000,93.75|466.164,93.75|440.000,93.75|415.305,93.75|391.995,93.75|415.305,93.75|391.995,93.75|369.994,93.75|349.228,93.75|369.994,93.75|391.995,93.75|415.305,93.75|440.000,93.75|466.164,93.75|493.883,93.75|466.164,93.75|440.000,93.75|466.164,187.5|233.082,93.75|233.082,93.75|233.082,93.75|233.082,93.75|233.082,93.75|233.082,93.75|246.942,93.75|246.942,93.75|246.942,93.75|246.942,93.75|246.942,93.75|246.942,93.75|246.942,93.75|246.942,93.75|233.082,93.75|233.082,93.75|233.082,93.75|233.082,93.75|233.082,93.75|233.082,93.75|233.082,93.75|233.082,93.75|246.942,93.75|246.942,93.75|246.942,93.75|246.942,93.75|246.942,93.75|246.942,93.75|246.942,93.75|246.942,93.75|233.082,93.75|233.082,93.75|233.082,93.75|233.082,93.75|246.942,93.75|246.942,93.75|246.942,93.75|246.942,93.75|233.082,93.75|233.082,93.75|220.000,93.75|246.942,93.75|207.652,93.75|261.626,93.75|277.183,93.75|293.665,93.75|277.183,93.75|261.626,93.75|246.942,93.75|233.082,93.75|246.942,93.75|261.626,93.75|277.183,93.75|293.665,93.75|277.183,93.75|261.626,93.75|246.942,93.75|233.082,93.75|261.626,93.75|277.183,93.75|293.665,93.75|311.127,187.5|311.127,93.75|311.127,93.75|311.127,93.75|311.127,93.75|311.127,93.75|311.127,93.75|329.628,93.75|329.628,93.75|329.628,93.75|329.628,93.75|329.628,93.75|329.628,93.75|329.628,93.75|329.628,93.75|311.127,93.75|311.127,93.75|311.127,93.75|311.127,93.75|311.127,93.75|311.127,93.75|311.127,93.75|329.628,93.75|329.628,93.75|329.628,93.75|329.628,93.75|329.628,93.75|329.628,93.75|329.628,93.75|329.628,93.75|311.127,93.75|311.127,93.75|311.127,93.75|311.127,93.75|329.628,93.75|329.628,93.75|329.628,93.75|329.628,93.75|311.127,93.75|311.127,93.75|293.665,93.75|329.628,93.75|277.183,93.75|349.228,93.75|261.626,93.75|369.994,93.75|391.995,93.75|369.994,93.75|349.228,93.75|329.628,93.75|311.127,93.75|329.628,93.75|349.228,93.75|369.994,93.75|391.995,93.75|369.994,93.75|349.228,93.75|329.628,93.75|311.127,93.75|261.626,93.75|277.183,93.75|293.665,93.75|622.254,93.75|587.330,93.75|554.365,93.75|523.251,93.75|493.883,93.75|659.255,93.75|659.255,93.75|622.254,93.75|587.330,93.75|622.254,93.75|587.330,93.75|554.365,93.75|523.251,93.75|493.883,93.75|523.251,93.75|554.365,93.75|587.330,93.75|622.254,93.75|587.330,93.75|554.365,93.75|523.251,93.75|554.365,93.75|523.251,93.75|493.883,93.75|466.164,93.75|493.883,93.75|523.251,93.75|554.365,93.75|587.330,93.75|554.365,93.75|587.330,93.75|622.254,93.75|659.255,93.75|698.456,93.75|659.255,93.75|622.254,93.75|587.330,93.75|622.254,93.75|587.330,93.75|554.365,93.75|523.251,93.75|554.365,93.75|523.251,93.75|493.883,93.75|466.164,93.75|440.000,93.75|415.305,93.75|391.995,93.75|369.994,93.75|349.228,93.75|369.994,93.75|349.228,93.75|329.628,93.75|174.614,187.5|138.591,187.5|116.541,187.5|103.826,187.5|116.541,187.5|138.591,187.5|174.614,375|174.614,187.5|138.591,187.5|116.541,187.5|103.826,187.5|116.541,187.5|138.591,187.5|174.614,375|311.127,93.75|293.665,93.75|277.183,93.75|261.626,93.75|277.183,93.75|261.626,93.75|246.942,93.75|233.082,93.75|220.000,93.75|207.652,93.75|195.998,93.75|184.997,93.75|174.614,93.75|184.997,93.75|174.614,93.75|164.814,93.75|698.456,187.5|554.365,187.5|466.164,187.5|369.994,187.5|466.164,187.5|554.365,187.5|698.456,375|1396.91,187.5|1108.73,187.5|932.328,187.5|739.989,187.5|932.328,187.5|1108.73,187.5|1396.91,375|');
		break;
	default:
		echo 'Usage: '. $_SERVER['argv'][0] .' SONG' ."\n"
		    .'Songs:'."\n"
		    .'   "scale"       - Play a musical scale'."\n"
		    .'   "gentlemen"   - God Rest Ye Merry Gentlemen (Christmas Carol)'."\n"
		    .'   "deckhalls"   - Deck the Halls (Christmas Carol)'."\n"		
		    .'   "entertainer" - The Entertainer (Scott Joplin)'."\n"
		    .'   "bumblebee"   - Flight of the Bumblebee (Nikolai Rimsky)'."\n"
		    .'   "crazytrain"  - Crazy Train (Ozzy Osbourne)'."\n"	
		    .'   "movitit"     - I Like to Move It (Reel 2 Real)'."\n"
		    .'   "clocks"      - Clocks (Coldplay)'."\n"
		    .'   "empire"      - Imperial March (Movie: Star Wars)'."\n"		
		    .'   "pinkpanther" - The Pink Panther Theme (Movie: The Pink Panther)'."\n"
		    .'   "ffvictory"   - Victory Theme (Game: Final Fantasy)'."\n"
		    .'   "mario"       - Underwater Theme (Game: Super Mario Bros.)'."\n"
		    .'   "stillalive"  - "Still Alive" (Game: Portal)';
}

function parseMusicStr($str){
	$tones = explode('|', $str);
	
	foreach ($tones as $tone){
		$part = explode(',', $tone);
		
		if ($part[0] == 'R'){
			usleep($part[1]);
		}
		else {
			beep($part[0], $part[1]);
		}
	}
}
										
function note($hertz = 440, $notenum){
	return pow(2, ($notenum / 12)) * $hertz;
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


