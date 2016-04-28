<?php
/**
 * img2html.php
 *
 * Convert an image into a HTML table
 *
 * Takes an image and converts it into a table of equal size with each cell
 * colored according to the associated pixel of the real image. Note the
 * process is very slow and medium to large images might temporarily freeze
 * the browser while rendering
 */

?>
<html>
    <head>
        <style>
            table {
                border-spacing: 0;
                border-collapse: collapse;
            }
            td {
                min-width: 4px;
                min-height: 1px;

                font-size: 2px;
                margin: 0;
                padding: 0;
            }
        </style>
    </head>
    <body>

    <?php

    if (isset($_FILES['img']['tmp_name']) && $_FILES['img']['tmp_name'] != '') {
        // Get image's extension
        switch ($_FILES['img']['type']){
            case 'image/jpeg':
                $gd = imagecreatefromjpeg($_FILES['img']['tmp_name']);
                break;
            case 'image/png':
                $gd = imagecreatefrompng($_FILES['img']['tmp_name']);
                break;
            case 'image/gif':
                $gd = imagecreatefromgif($_FILES['img']['tmp_name']);
                break;
            default:
                trigger_error('Unknown file extension!' , E_USER_ERROR);
        }

        $width  = imagesx($gd);
        $height = imagesy($gd);

        echo '<table width="' . $width . 'px" height="' . $height . 'px">';
        for ($y = 0; $y < $height; $y++){
            echo '<tr>';
            for ($x = 0; $x < $width; $x++){
                $rgba = imagecolorsforindex($gd, imagecolorat($gd, $x, $y));

                echo '<td style="background-color: rgb(' . $rgba['red'] . ', ' . $rgba['green'] . ', ' . $rgba['blue'] . ')">&nbsp;</td>';
            }
            echo '</tr>';
        }
        echo '</table>';

        imagedestroy($gd);
    }
    else {
    ?>
        <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input name="img" type="file" size="50" class="button"><br>
        <input type="submit" name="action" value="Convert!" class="button">
        </form>
    <?php } ?>

    </body>
</html>
