<?php
session_start(); //to ensure you are using same session
session_unset();
session_destroy();
ob_start(); //destroy the session
header("location:index.php"); //to redirect back to "index.php" after logging out
exit();
?>