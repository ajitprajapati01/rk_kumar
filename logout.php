<?php
session_start();        // Session start karo        // Sare session variables unset karo
if(session_destroy()){
    header("Location:login.php"); 

}     // Session destroy karo

// Wapas login page pe bhej do

?>
