<?php
/**
 * img_crypt.php
 *
 * Encoding a Message into a Image
 *
 * Converts plain text into a pixelated image with each pixel representing
 * the binary value of each ascii character in the message.
 */

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'Encode') {
        $message = trim($_POST['message']);
        $encimg = bin2pix(txt2bin($message));
        $encimg = 'data:image/png;base64,' . base64_encode(file_get_contents($encimg));
    }
    else { // Decode
        if (isset($_FILES['encimg']['tmp_name']) && $_FILES['encimg']['tmp_name'] != ''){
            $message = bin2txt(pix2bin($_FILES['encimg']['tmp_name']));
        }
        else {
            trigger_error('No image was provided to decode!' , E_USER_ERROR);
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
        <h1>Encode a Message into a Image</h1>
        <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <table>

            <?php if (isset($encimg)) { ?>
                <tr>
                    <td><strong>Encoded<br>Image</strong></td>
                    <td>
                        <img src="<?php echo $encimg; ?>" style="width: 200px; height: 200px">
                    </td>
                </tr>
            <?php } ?>

                <tr>
                    <td>
                        <strong>Plain<br>Text</strong>
                    </td><td>
                        <textarea rows="15" cols="50" name="message" WRAP="SOFT"><?php if (isset($message)) echo $message; ?></textarea>
                    </td>
                </tr><tr>
                    <td>
                        <strong>Image<br>Upload</strong>
                    </td><td>
                        <input name="encimg" type="file" size="50" class="button">
                    </td>
                </tr><tr>
                    <td colspan="2">
                        <center>
                            <input type="submit" name="action" value="Encode" class="button">
                            <input type="submit" name="action" value="Decode" class="button">
                        </center>
                    </td>
                </tr>
            </table>
        </form>
        <br><br>

        <h2>Encode</h2>
        <p>
        Type a message then click the <em>Encode</em> button. The the given message is converted into binary, then
        the binary is transformed into an image with each pixel representing a 0 or 1. Note that the image size will
        increase with the message length, however for display purposes the image is always scaled to a 200px square.
        </p>

        <h2>Decode</h2>
        <p>
        Click the <em>Choose File</em> button and upload an encoded image created with this script. Then click the
        <em>Decrypt</em> button. The image will be decoded (decoding is simply the above encoding in reverse) and
        message will be outputted to the <em>Plain Text</em> text field.
        </p>
    </body>
</html>
