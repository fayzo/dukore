<?php 
session_start();
include('../init.php');
$users->preventUsersAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

if (isset($_POST['like']) && !empty($_POST['like'])) {
    $user_id= $_SESSION['user_id'];
    $tweet_id= $_POST['like'];
    $get_id= $_POST['userid'];
    $homepage->addLike( $user_id,$tweet_id, $get_id);
}

if (isset($_POST['unlike']) && !empty($_POST['unlike'])) {
    $user_id= $_SESSION['user_id'];
    $tweet_id= $_POST['unlike'];
    $get_id= $_POST['userid'];
    $homepage->unLike( $user_id,$tweet_id, $get_id);
}

?>
