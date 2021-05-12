<?php 
session_start();
include('../init.php');
$users->preventUsersAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

if (isset($_POST['follow']) && !empty($_POST['follow'])) {
    $user_id= $_SESSION['user_id'];
    $follow_id= $_POST['follow'];
    $follow->follows($follow_id,$user_id);
    // $result['following']= "1";
    // echo json_encode($result);
}

if (isset($_POST['unfollow']) && !empty($_POST['unfollow'])) {
    $user_id= $_SESSION['user_id'];
    $follow_id= $_POST['unfollow'];
    $follow->unfollow($follow_id,$user_id);
    // $result['following']= 0;
    // echo json_encode($result);
}
?>