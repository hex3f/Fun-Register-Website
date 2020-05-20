<?php
session_start();
session_destroy();
header("location:../getkey/login.php");
?>