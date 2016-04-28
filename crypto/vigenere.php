<?php
/**
 * vigenere.php
 *
 * PHP implementation of a Vigenère cipher
 *
 * Encrypts and decrypts text based the on the Vigenère cipher. This
 * version is compatible with the generic pen and paper method, meaning
 * non A-Z characters are ignored. Like the original, the password is
 * padded by repeating itself until the length matches the message
 * length. A Vigenère square / tabula recta is not needed, as the
 * encoding is done on the fly.
 */

if (isset($_POST['message'])){
    $message  = $_POST['message'];
    $password = strtoupper($_POST['password']);

    // Pad Password same length as message
    $password = preg_replace('/[^A-Z]/', '', $password);
    $password = str_pad($password, strlen($message), $password);

    // Seperate counter for the password, so spaces and commas don't change the encryption.

    $pass_i = 0;

    for($i=0; $i < strlen($message); $i++){
        $m_letter = strtoupper($message{$i});
        $p_letter = $password{$pass_i};

        $m_pos = ord($m_letter) - 65;
        $p_pos = ord($p_letter) - 65;

        // If the character is a letter and not a space, period, comma, etc...
        if (preg_match('/^[A-Z]$/', $m_letter)) {

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
    <input name="password" type="text"><br />

    <input name="encrypt" type="submit" value="Encrypt" />
    <input name="decrypt" type="submit" value="Decrypt" />
</form>

