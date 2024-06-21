<?php
// session_start([
//     'cookie_lifetime' => 1440, // 24 minutes in seconds
// ]);
// $session_timeout = 1440;
// if (isset($_SESSION['LAST_ACTIVITY'])) {
//     $elapsed_time = time() - $_SESSION['LAST_ACTIVITY'];
//     if ($elapsed_time >= $session_timeout) {
//         // Session expired
//         session_unset();    // Unset session variables
//         session_destroy();  // Destroy the session
//         session_start([     // Start a new session
//             'cookie_lifetime' => 1440,
//         ]);
//     }
// }

// // Update last activity time stamp
// $_SESSION['LAST_ACTIVITY'] = time();

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

require "../private/core/init.php";

$app = new App();   
