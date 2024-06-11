<?php
session_start();

// $url = explode ("/","$_SERVER[REQUEST_URI]");
// if(count($url)==5){
//     echo '<base href="../">';
// }else if(count($url)==6){
//     echo '<base href="../../">';
// }else if(count($url)==7){
//     echo '<base href="../../../">';
// }else if(count($url)==8){
//     echo '<base href="../../../../">';
// }else if(count($url)==9){
//     echo '<base href="../../../../../">';
// }

$url = explode ("/","$_SERVER[REQUEST_URI]");
if(count($url)==4){
    echo '<base href="../">';
}else if(count($url)==5){
    echo '<base href="../../">';
}else if(count($url)==6){
    echo '<base href="../../../">';
}else if(count($url)==7){
    echo '<base href="../../../../">';
}else if(count($url)==8){
    echo '<base href="../../../../../">';
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "../private/core/init.php";

$app = new App();   
