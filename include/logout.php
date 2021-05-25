<?php
session_start();
include('../core/init.php');
$users->loggedin();
$users->logout();
?>