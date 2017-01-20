#!/usr/bin/php
<?php
	$file = 'primes.txt';
	$places = 10;

	$goal = str_pad(1, $places, '0');

	if (file_exists($file)) {
		$size      = format_bytes(filesize($file));
		$start     = flastline($file);
		$percent   = floor(($start / $goal) * 100);

		echo "Found previous run.\n"
		    ." -> File Size:        $size\n"
		    ." -> Last Found Prime: $start\n"
		    ." -> Percent Done:     $percent%\n\n";
	}
	else {
		echo "No previous run found, starting a new one.\n\n";
		$start = 1;
	}



	echo "Starting benchmark for primes after ". $start ."\n";
	$benchmark = 0;
	$number = $start + 1;
	$endtime = time() + 10;
	while (time() <= $endtime){
		if (isprime($number)){
			$benchmark++;
		}
		$number++;
	}
	echo " -> Number Found: $benchmark\n"
	    ." -> Runtime:      10 secs\n\n";




	$data = array();
	$number = $start + 1; // Add one to the last found prime

	echo "Starting prime search at $number\n";

	while (TRUE){
		if (isprime($number)){
			$data[] = $number;
		}

		$number++;

		if (sizeof($data) > ($benchmark * 3)){ // Dump 30 secs worth of primes
			$lastfound = end($data);

			$percent   = ($lastfound / $goal * 100);
			echo ' -> Dumping found primes: '. $percent . '% done'."\n";

			$data = implode("\n", $data);
			$data = $data ."\n";

			$f = fopen($file, 'a');
			fwrite($f, $data);
			fclose($f);

			$data = array();
		}
	}

function format_bytes($size) {
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
    return round($size, 2).$units[$i];
}


function isprime($num){
	$max = floor(sqrt($num));

	for ($i=2; $i <= $max; $i++){
		if ($num % $i == 0) return FALSE;
	}

	if ($i == ($max + 1)) return TRUE;

}


function flastline($file){
/* flastline()
 *     Read a huge file's last line without putting it in memory
 *     http://stackoverflow.com/questions/1510141/read-last-line-from-file
 */

	$line = '';

	$f = fopen($file, 'r');
	$cursor = -1;

	fseek($f, $cursor, SEEK_END);
	$char = fgetc($f);

	while ($char === "\n" || $char === "\r") {
		fseek($f, $cursor--, SEEK_END);
		$char = fgetc($f);
	}

	while ($char !== false && $char !== "\n" && $char !== "\r") {
		$line = $char . $line;
		fseek($f, $cursor--, SEEK_END);
		$char = fgetc($f);
	}

	return $line;

}

?>
