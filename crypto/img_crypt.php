<?php
/**
 * img_crypt.php
 *
 * Binary Encryption to a Image
 *
 * Converts plain text into a innocuous looking pixelated image. Each
 * pixel, depending on the color, represents a binary bit of the encoded
 * message.
 *
 * Copyright (C) 2014 Timothy Keith <timothy@keithieopia.com>
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
 * @copyright   Timothy Keith 2014
 * @license     https://www.gnu.org/licenses/gpl.html
 * @link        http://keithieopia.com
 */

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'Encrypt') {
        $message = trim($_POST['message']);
        $encimg = bin2pix(txt2bin($message));
        $encimg = 'data:image/png;base64,' . base64_encode(file_get_contents($encimg));
    }
    else { // Decrypt
        if (isset($_FILES['encimg']['tmp_name']) && $_FILES['encimg']['tmp_name'] != ''){
            $message = bin2txt(pix2bin($_FILES['encimg']['tmp_name']));
        }
        else {
            trigger_error('No image was provided to decrypt!' , E_USER_ERROR);
        }
    }
}


/*****************************************************************************************************************
   >>> Begin PHP Functions Section
*****************************************************************************************************************/

function txt2bin($txt) {
    $binary = '';

    $len = strlen($txt);
    for ($i = 0; $i < $len; $i++) {
        $ascii = ord($txt[$i]);
        $byte  = sprintf( "%08d", decbin( $ascii )); // pad bits to a byte (8 bits)

        $binary .= $byte;
    }

    return $binary;
}

function bin2txt($binary) {
    $text = '';

    $bytes = str_split($binary, 8);
    foreach ($bytes as $byte) {
        $ascii = chr(bindec($byte));
        $text .= $ascii;
    }

    return $text;
}

function bin2pix($str) {
    $mess_arr = str_split($str);

    $xy = ceil(sqrt(strlen($str))); // Round to nearest square

    $gd = imagecreatetruecolor($xy, $xy);

    $red = imagecolorallocate($gd, 255, 0, 0);
    $green = imagecolorallocate($gd, 0, 255, 0);
    $black = imageColorAllocate($gd, 0, 0, 0);

    $i=0;
    for ($y=0; $y<$xy; $y++){
        for ($x=0; $x<$xy; $x++){
            if ($i >= strlen($str)) {
                imagesetpixel($gd, $x, $y, $black);
            }
            else {
                if ($mess_arr[$i] == 1) imagesetpixel($gd, $x, $y, $red);
                else if ($mess_arr[$i] == 0) imagesetpixel($gd, $x, $y, $green);
            }
            $i++;
        }
    }

    $enc_img = "./tmp/" . time() . ".png";

    $tmp_file = tempnam(sys_get_temp_dir(), 'encbintxt');


    imagepng($gd, $tmp_file);
    imagedestroy($gd);

    return $tmp_file;
}

function pix2bin($image){

   $im = imagecreatefrompng($image);
   $xy = imagesx($im);

   $str = "";
   for ($y=0; $y<$xy; $y++){
      for ($x=0; $x<$xy; $x++){
         $rgb = imagecolorat($im, $x, $y);
         $r = ($rgb >> 16) & 0xFF;
         $g = ($rgb >> 8) & 0xFF;
         $b = $rgb & 0xFF;

         if ($r == 255) $str .= "1";
         if ($g == 255) $str .= "0";

      }
   }

   return $str;
}

/*****************************************************************************************************************
   >>> Begin HTML Code Section
*****************************************************************************************************************/
?>

<html>
    <body>
        <h1>Binary Encryption to Image</h1>
        <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="timcrypt">
            <table>

            <?php if (isset($encimg)) { ?>
                <tr>
                    <td><strong>Encrypted<br>Image</strong></td>
                    <td>
                        <img src="<?php echo $encimg; ?>" style="width: 200px; height: 200px">
                    </td>
                </tr>
            <?php } ?>

                <tr>
                    <td>
                        <strong>Secret<br>Message</strong>
                    </td><td>
                        <textarea rows="15" cols="50" name="message" WRAP="SOFT"><?php if (isset($message)) echo $message; ?></textarea>
                    </td>
                </tr><tr>
                    <td>
                        <strong>Image Upload</strong><br>
                        <em>To Decrypt</em>
                    </td><td>
                        <input name="encimg" type="file" size="50" class="button">
                    </td>
                </tr><tr>
                    <td colspan="2">
                        <center>
                            <input type="submit" name="action" value="Encrypt" class="button">
                            <input type="reset" value="Clear All" class="button">
                            <input type="submit" name="action" value="Decrypt" class="button">
                        </center>
                    </td>
                </tr>
            </table>
        </form>
        <br><br>

        <h2>Encryption</h2>
        <p>
        Type a message then click the <em>Encrypt</em> button. The the given message is converted into binary, then the binary
        is transformed into an image with each pixel representing a 0 or 1. Note that the image size will increase
        with the message length, however for display purposes the image is always scaled to a 200px square.
        </p>

        <h2>Decryption</h2>
        <p>
        Click the <em>Choose File</em> button and upload an encrypted image created with this script. Then click the
        <em>Decrypt</em> button. The image will be decrypted (decryption is simply the above encryption in reverse) and
        the secret message will be outputted to the <em>Secret Message</em> text field.
        </p>
    </body>
</html>
