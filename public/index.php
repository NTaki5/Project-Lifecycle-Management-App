<?php
session_start();

$url = explode ("/","$_SERVER[REQUEST_URI]");
if(count($url)==5){
    echo '<base href="../">';
}else if(count($url)==6){
    echo '<base href="../../">';
}else if(count($url)==7){
    echo '<base href="../../../">';
}else if(count($url)==8){
    echo '<base href="../../../../">';
}else if(count($url)==9){
    echo '<base href="../../../../../">';
}

require "../private/core/init.php";

$app = new App();   
