<?php 
session_start();
include('../init.php');
$users->preventUsersAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

if (isset($_GET['showNotification']) && !empty($_GET['showNotification'])) {
    $user_id= $_SESSION['user_id'];
    $data= $notification->getNotificationCount($user_id);
    echo json_encode(array('notification' => $data['totalnotification'],'messages' => $data['totalmessage'] ));
}
?>