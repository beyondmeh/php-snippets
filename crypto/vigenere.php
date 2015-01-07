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
 *
 * Copyright (C) 2011 Timothy Keith <timothy@keithieopia.com>
 *
 * LICENSE: This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License
 * for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author      Timothy Keith <timothy@keithieopia.com>
 * @copyright   Timothy Keith 2011
 * @license     https://www.gnu.org/licenses/gpl.html
 * @link        http://keithieopia.com
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

