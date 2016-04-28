<?php
/**
 * caesar.php
 *
 * PHP implementation of a shift cipher
 *
 * Encrypts and decrypts text based on a alphabetic shift/rotation cipher
 * such as the Caesar and ROT13 ciphers. This version is compatible with
 * the generic pen and paper method: the text is NOT transformed to ASCII
 * before the rotation (non A-Z characters are ignored).
 */

if (isset($_POST['message'])){
    $message  = $_POST['message'];
    $rotation = $_POST['rotation'];

    for($i=0; $i < strlen($message); $i++){

        $letter   = strtoupper($message{$i});

        // If the character is a letter and not a space, period, comma, etc...
        if (preg_match("/^[A-Z]$/", $letter)) {

            // Turn the letter into it's numeric position in the alphabet
            // eg: A = 1, B = 2, etc....
            $position = ((int) ord($letter) - 64);

            if (isset($_POST['encrypt'])){

                if (($position + $rotation) > 26) {
                    $position = ($position + $rotation) - 26;
                }
                else {
                    $position = $position + $rotation;
                }
            }

            if (isset($_POST['decrypt'])){
                // We add 26 to prevent a negative
                $position = (26 + ($position - $rotation)) % 26;
            }

            // Turn position back into a letter
            $letter = chr($position + 64);

            // Lowercase letter if it was in the message
            if (ctype_lower($_POST['message']{$i})){
                $letter = strtolower($letter);
            }

            // Set the letter in the message
            $_POST['message']{$i} = $letter;
        }
    }
}

?>

<h1>Hello Mrs. Keith's &amp; Mrs. Smith's Classes!</h1>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <textarea name="message" cols="40" rows="5"><?php if (isset($_POST['message'])) echo $_POST['message']; ?></textarea><br />

Rotation:

    <select name="rotation">
        <option value="1">1  (A => B)</option>
        <option value="2">2  (A => C)</option>
        <option value="3">3  (A => D)</option>
        <option value="4">4  (A => E)</option>
        <option value="5">5  (A => F)</option>
        <option value="6">6  (A => G)</option>
        <option value="7">7  (A => H)</option>
        <option value="8">8  (A => I)</option>
        <option value="9">9  (A => J)</option>
        <option value="10">10 (A => K)</option>
        <option value="11">11 (A => L)</option>
        <option value="12">12 (A => M)</option>
        <option value="13">13 (A => N)</option>
        <option value="14">14 (A => O)</option>
        <option value="15">15 (A => P)</option>
        <option value="16">16 (A => Q)</option>
        <option value="17">17 (A => R)</option>
        <option value="18">18 (A => S)</option>
        <option value="19">19 (A => T)</option>
        <option value="20">20 (A => U)</option>
        <option value="21">21 (A => V)</option>
        <option value="22">22 (A => W)</option>
        <option value="23">23 (A => X)</option>
        <option value="24">24 (A => Y)</option>
        <option value="25">25 (A => Z)</option>
    </select><br />

    <input name="encrypt" type="submit" value="Encrypt" />
    <input name="decrypt" type="submit" value="Decrypt" />
</form>


if (isset($_POST['message'])){
    $message  = $_POST['message'];
    $rotation = $_POST['rotation'];

    for($i=0; $i < strlen($message); $i++){

        $letter   = strtoupper($message{$i});

        // If the character is a letter and not a space, period, comma, etc...
        if (preg_match("/^[A-Z]$/", $letter)) {

            // Turn the letter into it's numeric position in the alphabet
            // eg: A = 1, B = 2, etc....
            $position = ((int) ord($letter) - 64);

            if (isset($_POST['encrypt'])){

                if (($position + $rotation) > 26) {
                    $position = ($position + $rotation) - 26;
                }
                else {
                    $position = $position + $rotation;
                }
            }

            if (isset($_POST['decrypt'])){
                // We add 26 to prevent a negative
                $position = (26 + ($position - $rotation)) % 26;
            }

            // Turn position back into a letter
            $letter = chr($position + 64);

            // Lowercase letter if it was in the message
            if (ctype_lower($_POST['message']{$i})){
                $letter = strtolower($letter);
            }

            // Set the letter in the message
            $_POST['message']{$i} = $letter;
        }
    }
}

?>

<h1>Hello Mrs. Keith's &amp; Mrs. Smith's Classes!</h1>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <textarea name="message" cols="40" rows="5"><?php if (isset($_POST['message'])) echo $_POST['message']; ?></textarea><br />

Rotation:

    <select name="rotation">
        <option value="1">1  (A => B)</option>
        <option value="2">2  (A => C)</option>
        <option value="3">3  (A => D)</option>
        <option value="4">4  (A => E)</option>
        <option value="5">5  (A => F)</option>
        <option value="6">6  (A => G)</option>
        <option value="7">7  (A => H)</option>
        <option value="8">8  (A => I)</option>
        <option value="9">9  (A => J)</option>
        <option value="10">10 (A => K)</option>
        <option value="11">11 (A => L)</option>
        <option value="12">12 (A => M)</option>
        <option value="13">13 (A => N)</option>
        <option value="14">14 (A => O)</option>
        <option value="15">15 (A => P)</option>
        <option value="16">16 (A => Q)</option>
        <option value="17">17 (A => R)</option>
        <option value="18">18 (A => S)</option>
        <option value="19">19 (A => T)</option>
        <option value="20">20 (A => U)</option>
        <option value="21">21 (A => V)</option>
        <option value="22">22 (A => W)</option>
        <option value="23">23 (A => X)</option>
        <option value="24">24 (A => Y)</option>
        <option value="25">25 (A => Z)</option>
    </select><br />

    <input name="encrypt" type="submit" value="Encrypt" />
    <input name="decrypt" type="submit" value="Decrypt" />
</form>
