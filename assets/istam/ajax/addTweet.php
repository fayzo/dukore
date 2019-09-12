<?php 
session_start();
include('../init.php');
$users->preventUsersAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

if (isset($_POST) && !empty($_POST)) {
    $user_id= $_SESSION['user_id'];
    $status= $users->test_input($_POST['status']);
	$files= $_FILES['file'];
    $tweetimages="";
    // echo $status;
    // echo $files;

    if (!empty($status) || !empty($files)) {
		if (!empty($files)) {
			# code...
			$tweetimages = $homepage->uploadImageProfiles($files);
		}

		if (strlen($status) > 140) {
			$errror= "The text is too long";
		}
		$tweet_id = $homepage->creates('Tweety',array('status' => $status, 'tweetBy' => $user_id, 'tweet_image' => $tweetimages, 'posted_on' => date('Y-m-d H-i-s')));
		preg_match_all("/#+([a-zA-Z0-9_]+)/i",$status, $hashtag);
		if (!empty($hashtag)) {
			# code...
            $homepage->addTrends($status);
        }
		$homepage->addmention($status,$user_id,$tweet_id);

         $result['success']= 'you tweet has been successful posted';
         echo json_encode($result);

		# code...
	}else {
		# code...
		$error= "Type or choose image to tweet";
    }
    
    if (isset($error)) {
        # code...
        $result['error']= $error;
        echo json_encode($result);
    }

}
?>