<?php 
session_start();
include('../init.php');
$users->preventUsersAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

if (isset($_POST['deletecomment']) && !empty($_POST['deletecomment'])) {
    $user_id= $_SESSION['user_id'];
	$deletecomment_id= $_POST['deletecomment'];
    $comment->delete('comment',array('comment_id' => $deletecomment_id,'comment_by' => $user_id));
    
}
?>