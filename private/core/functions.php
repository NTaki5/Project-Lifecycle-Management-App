<?php

use function PHPSTORM_META\map;

function get_var($key){
    if(isset($_POST[$key])){
        return $_POST[$key];
    }
}

function esc($var){
    return htmlspecialchars($var);
}

// Convert png, jpg, gif to webp and reduce the file size
function webpImage($path, $cover = '', $quality = 100, $removeOld = false, $width = 0, $height = 0)
{
    if (strlen($cover)) {
        $source = $path . '/' . $cover;
    } else {
        $source = $path;
    }

    $imgSize = filesize("$source") / 1024;
    $dir = pathinfo($source, PATHINFO_DIRNAME);
    $name = pathinfo($source, PATHINFO_FILENAME);
    $destination = $dir . DIRECTORY_SEPARATOR . $name . '.webp';
    $info = getimagesize($source);

    $isAlpha = false;

    if ($width == 0) {
        $width = $info[0];
    }

    if ($height == 0) {
        $height = $info[1];
    }

    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
    } elseif ($isAlpha = $info['mime'] == 'image/gif') {
        $image = imagecreatefromgif($source);
    } elseif ($isAlpha = $info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);
    } else {
        //   copy($source, $destination);
        resize_image_webp($source, $destination, $width, $height, $quality, FALSE);
        return $source;
    }

    if ($isAlpha) {

        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

    }


    if ($imgSize <= 75) {
        $quality = 100;
        imagewebp($image, $destination, $quality);

        if ($removeOld)
            unlink($source);
    } else {
        imagewebp($image, $destination, $quality);


        if (resize_image_webp($source, $destination, $width, $height, $quality, FALSE)) {
            if ($removeOld)
                unlink($source);
        } else return false;
    }

    imagedestroy($image);


    return $destination;
}

function resize_image_webp($source_file, $destination_file, $width, $height, $quality, $crop = TRUE)
{
    list($current_width, $current_height) = getimagesize($source_file);
    if ($current_width && $current_height) {
        $rate = $current_width / $current_height;
        if ($crop) {
            if ($current_width > $current_height) {
                $current_width = ceil($current_width - ($current_width * abs($rate - $width / $height)));
            } else {
                $current_height = ceil($current_height - ($current_height * abs($rate - $width / $height)));
            }
            $newwidth = $width;
            $newheight = $height;
        } else {
            if ($width / $height > $rate) {
                $newwidth = $height * $rate;
                $newheight = $height;
            } else {
                $newheight = $width / $rate;
                $newwidth = $width;
            }
        }

        $source_file = str_replace(".jpg", '.webp', $source_file);
        $source_file = str_replace('.gif', '.webp', $source_file);
        $source_file = str_replace('.png', '.webp', $source_file);

        $info = getimagesize($source_file);

        if ($info['mime'] == 'image/jpeg') {
            if ($src_file = imagecreatefromjpeg($source_file)) ;
            $dst_file = imagecreatetruecolor($newwidth, $newheight);

        } elseif ($info['mime'] == 'image/gif') {
            if ($src_file = imagecreatefromgif($source_file)) ;
            $dst_file = imagecreatetruecolor($newwidth, $newheight);
        } elseif ($info['mime'] == 'image/png') {
            if ($src_file = imagecreatefrompng($source_file)) ;
            $dst_file = imagecreatetruecolor($newwidth, $newheight);
        } elseif ($info['mime'] == 'image/webp') {
            if ($src_file = imagecreatefromwebp($source_file)) ;
            $dst_file = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($dst_file, $src_file, 0, 0, 0, 0, $newwidth, $newheight, $current_width, $current_height);
            copy($source_file, $destination_file);
            return $source_file;
        } else {
            return $source_file;
        }

        imagecopyresampled($dst_file, $src_file, 0, 0, 0, 0, $newwidth, $newheight, $current_width, $current_height);
        return imagewebp($dst_file, $destination_file, $quality);
    } else return false;

}

// convert a string into a URL-friendly "slug"
function slugify($text, $strict = false)
{
    $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d.]+~u', '-', $text);

    // trim
    $text = trim($text, '-');
    setlocale(LC_CTYPE, 'en_GB.utf8');
    // transliterate
    if (function_exists('iconv')) {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    }

    // lowercase
    $text = strtolower($text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w.]+~', '', $text);
    if (empty($text)) {
        return 'empty_$';
    }
    if ($strict) {
        $text = str_replace(".", "_", $text);
    }
    return $text;
}
function add_webp_image($path, $image_name,$image_tmp_name, $quality = 100, $remove_old = true)
{
    // Checking if any image was uploaded
    if (empty($image_name)) {
        return '';
    }
    if (!file_exists($path)) {
        // If not, create the directory
        mkdir($path, 0777, true);
    }
    //Getting the extension for the file
    $fileExtension = '.' . pathinfo($image_name, PATHINFO_EXTENSION);

    //Generating the name for the new file
    $image = slugify(substr($image_name, 0, strpos($image_name, '.'))) . '-' . mt_rand() . $fileExtension;

    //getimagesize doens't support vector images
    //we don't need to get an SVG's MIME type anyway
    if ($info = getimagesize($image_tmp_name)) {
        //Replacing extension with MIME type preventing
        //files with wrong extensions to break the resizer
        $image = str_replace($fileExtension, '.' . str_replace('image/', '', $info['mime']), $image);
        $fileExtension = '.' . str_replace('image/', '', $info['mime']);
    }

    //Checking for svg type, svg images are usually smaller they don't need to be resized
    if (strcmp($fileExtension, '.svg')) {
        if (strlen($image_tmp_name) != 0) {
            $image_temp = $image_tmp_name;
            //Uploading the image to be able to resize it to webp
            copy($image_temp, $path . DIRECTORY_SEPARATOR . $image);
            webpImage($path, $image, $quality, $remove_old);
            //The image currently has it's original extension
            $image = str_replace($fileExtension, '.webp', $image);
        }
    } else {
        $image_temp = $image_tmp_name;
        copy($image_temp, $path . DIRECTORY_SEPARATOR . $image);
    }

    //Returning the image name that get's uploaded in the database
    return $image;
}

function edit_webp_image($path, $image_name,$image_tmp_name,$existing_image_name, $quality=100, $remove_old=true)

{
    if (!file_exists($path)) {
        // If not, create the directory
        mkdir($path, 0777, true);
    }
    // Checking if any image was uploaded
    if (!empty($image_name)){

        $image_tmp_name  = $_FILES[$image_name]['tmp_name'];

        $fileExtension = '.' . pathinfo($image_name, PATHINFO_EXTENSION);
        $image = slugify(substr($image_name, 0, strpos($image_name, '.'))) . '-' . mt_rand() . $fileExtension;
        //getimagesize doens't support vector images
        //we don't need to get an SVG's MIME type anyway
        if ($info = getimagesize($image_tmp_name)) {
            //Replacing extension with MIME type preventing
            //files with wrong extensions to break the resizer
            $image = str_replace($fileExtension, '.' . str_replace('image/', '', $info['mime']), $image);
            $fileExtension = '.' . str_replace('image/', '', $info['mime']);
        }

        //Checking for svg type, svg images are usually smaller they don't need to be resized
        if (strcmp($fileExtension, '.svg')) {

            $image_old = $existing_image_name;
            if (strlen($image_old)) unlink($path . "/$image_old");
            
            $image = slugify(substr($image_name, 0, strpos($image_name, '.'))) . '-' . mt_rand() . $fileExtension;
            $image_temp = $image_tmp_name;
            copy($image_temp, $path . DIRECTORY_SEPARATOR . $image);
            webpImage($path, $image, $quality, $remove_old);
            $image = str_replace($fileExtension, '.webp', $image);
        } else {
            $fileExtension = '.svg';

            $image_old = $existing_image_name;
            if (strlen($image_old)) unlink($path . "/$image_old");
            
            $image = slugify(substr($image_name, 0, strpos($image_name, '.'))) . '-' . mt_rand() . $fileExtension;
            $image_temp = $image_tmp_name;
            copy($image_temp, $path . DIRECTORY_SEPARATOR . $image);
        }
    }
    return $image;
}

function get_avatars(){
    if(is_dir("assets/images/profile")){
        $list = scandir("assets/images/profile");
        if($list){
            unset($list[0]);
            unset($list[1]);
            $list = array_values($list);
            $avatars['paths'] = array_map(function($item){
                return ROOT . "/assets/images/profile/" . $item;
            }, $list);
            // print_r($avatars);die();
            $avatars['names'] = $list;
            return $avatars;
        }
        return [];
    }
}

function generateToken() {
    return bin2hex(random_bytes(32));
}

function getFormattedDate($date) {
    // Convert the date string to a timestamp
    $timestamp = strtotime($date);

    // Format the day with the appropriate suffix
    $day = date('j', $timestamp);
    if ($day == 1 || $day == 21 || $day == 31) {
        $daySuffix = 'st';
    } elseif ($day == 2 || $day == 22) {
        $daySuffix = 'nd';
    } elseif ($day == 3 || $day == 23) {
        $daySuffix = 'rd';
    } else {
        $daySuffix = 'th';
    }

    // Format the date with the day suffix
    $formattedDate = date('l, F j', $timestamp) . $daySuffix . date(', Y', $timestamp);

    return $formattedDate;
}

function findInObjectsArrayById($objectsArray, $findThat, $toBeEqualWith) {
    $returnArray = array();
    foreach ($objectsArray as $value) {
        if ($value->$findThat == $toBeEqualWith) {
            array_push($returnArray, $value);
        }
    }
    return $returnArray ; // Return null if value not found
}

function getDateInterval($date1, $date2 = new DateTime('now')){

    $currentSecond = $date2->format('s');
    $currentMinute = $date2->format('i');
    $currentHour = $date2->format('H');
    $currentDay = $date2->format('d');
    $currentMonth = $date2->format('m');
    $currentYear = $date2->format('Y');


    $interval = $date2->diff($date1);

    $displayTime = "";
    if ($interval->y > 0) {
        $displayTime .= $interval->y . " y ";
    }
    if ($interval->m > 0) {
        $displayTime .= $interval->m . " M ";
    }
    if ($interval->d > 0) {
        $displayTime .= $interval->d . " d ";
    }
    else{
        if ($interval->h > 0) {
            $displayTime .= $interval->h . " h ";
        }
        if ($interval->i > 0) {
            $displayTime .= $interval->i . " m ";
        }
    }
    if(!strlen($displayTime))
        $displayTime = "a few seconds ago";

        return $displayTime;
}

function hex2rgba($color, $opacity = false)
{
    $default = 'rgb(0,0,0)';
    if (empty($color))
        return $default;
    if ($color[0] == '#') {
        $color = substr($color, 1);
    }

    if (strlen($color) == 6) {
        $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    } elseif (strlen($color) == 3) {
        $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    } else {
        return $default;
    }

    $rgb = array_map('hexdec', $hex);
    if ($opacity) {
        if (abs($opacity) > 1)
            $opacity = 1.0;
        $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode(",", $rgb) . ')';
    }

    return $output;
}