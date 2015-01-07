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
