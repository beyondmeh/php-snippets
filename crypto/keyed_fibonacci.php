<?php
/*
 * A Polyalphabetic Cipher using a lagged fibonacci generator.
 * 
 * Encrypts and decrypts text given a certain password. The password
 * is used to seed a lagged fibonacci generator which in turn is used to 
 * generate a number for each letter of the message. That number is then
 * used to rotate each letter of the message.
 * 
 * Excluding the common issues with passwords and complexity, the cipher
 * itself is relatively secure for these types of ciphers. The lagged 
 * fibonacci generator effectively acts as pseudorandom number generator 
 * which in turn defeats frequency analysis. 
 * 
 * @author     Timothy Keith <timothy@keithieopia.com>
 * @copyright  2011 Timothy Keith
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       https://github.com/keithieopia/snippets
 */ 
 
if (isset($_POST['message'])){	
	$message  = $_POST['message'];
	$password = strtoupper($_POST['password']);
	
	$password = preg_replace('/[^A-Z]/', '', $password);

	// Generate the seed
	$seed = '';
	for ($i=0; $i < strlen($password); $i++){
		$seed .= ord($password{$i}) - 65;
	}

	
	/* Made a seed using a fibonacci like algorithm... 
	 * Add the last 2 letter's positions of the password 
	 * and mod it by 26 to get a letter.
	 */ 
	$password = '';

	$n1 = 1;
	$n2 = $seed;
	for ($i=0; $i < strlen($message); $i++){
		$n3 = ($n1 + $n2) % 26;
		
		$password .= chr($n3 + 65);
		
		$n1 = $n2;
		$n2 = $n3;
	}	
	
	/* Seperate counter for password, so spaces and commas don't change
	 * the encryption.
	 */ 

	$pass_i = 0; 

	for($i=0; $i < strlen($message); $i++){
		$m_letter = strtoupper($message{$i});
		$p_letter = strtoupper($password{$pass_i});
		
		$m_pos = ord($m_letter) - 65;
		$p_pos = ord($p_letter) - 65;

		// If the character is a letter and not a space, period, comma, etc...
		if (preg_match("/^[A-Z]$/", $m_letter)) { 
			
			if (isset($_POST['encrypt'])){
				$pos    = ($m_pos + $p_pos) % 26;
				$letter = chr($pos + 65);
			}

			if (isset($_POST['decrypt'])){
				// We add 26 to prevent a negative
				$pos    = (26 + ($m_pos - $p_pos)) % 26;
				$letter = chr($pos + 65);
			}

			// Lowercase letter if it was in the message
			if (ctype_lower($_POST['message']{$i})){
				$letter = strtolower($letter);
			}

			$_POST['message']{$i} = $letter;
			$pass_i++;
		} 
	}
}

?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<textarea name="message" cols="40" rows="5"><?php if (isset($_POST['message'])) echo $_POST['message']; ?></textarea><br />

	Password:
	<input name="password" type="text" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>"><br />
	
	Fibonacci: 
	<input type="text" name="fibonacci" value="<?php if (isset($password)) echo $password; ?>" disabled="disabled" /><br />
	
	<input name="encrypt" type="submit" value="Encrypt" />
	<input name="decrypt" type="submit" value="Decrypt" />
</form>
