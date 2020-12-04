<?php 
session_start();
include('../init.php');
$users->preventUsersAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

if (isset($_POST['retweet']) && !empty($_POST['retweet'])) {
    $user_id= $_SESSION['user_id'];
	$retweet_id= $_POST['retweet'];
	$tweet_by= $_POST['tweet_By'];
	$comment= $_POST['comments'];
	$comments= $users->test_input($comment);
	$homepage->retweet($retweet_id, $user_id,$tweet_by,$comments);
}

if (isset($_POST['showpopretweet']) && !empty($_POST['showpopretweet'])) {
    $user_id= $_SESSION['user_id'];
    $tweet_id= $_POST['showpopretweet'];
    $tweet_by= $_POST['tweet_By'];
	$retweet= $homepage->getPopupTweet($user_id, $tweet_id, $tweet_by); 
	?>
<?php

	  echo ' <div class="retweet-popup">
                <div class="wrap5">
                	<div class="retweet-popup-body-wrap">
                		<div class="retweet-popup-heading">
                			<h3>Retweet this to followers?</h3>
                			<span><button class="close-retweet-popup"><i class="fa fa-times" aria-hidden="true"></i></button></span>
                		</div>
                		<div class="retweet-popup-input">
                			<div class="retweet-popup-input-inner">
                				<input type="text" class="retweetMsg" placeholder="Add a comment.."/>
                			</div>
                		</div>
                		<div class="retweet-popup-inner-body">
                			<div class="retweet-popup-inner-body-inner">
                				<div class="retweet-popup-comment-wrap">
									 <div class="retweet-popup-comment-head">
						
									 '.((isset($user_id) == $retweet['user_id']  && empty($retweet['profile_image']) == 1)?
	 	                             '<img src="'.BASE_URL.NO_PROFILE_IMAGE_URL.'" />':'<img src="'.BASE_URL.$retweet["profile_image"].'"/>').'

                					 </div>
                					 <div class="retweet-popup-comment-right-wrap">
                						 <div class="retweet-popup-comment-headline">
                						 	<a>'.$retweet['screenname'].'</a><span>‏@'.$retweet['username'].' - '.$retweet['posted_on'].'</span>
                						 </div></br>
                						 <div class="retweet-popup-comment-body">
											 <div class="t-h-c-dis" style="margin-bottom:10px;">
											   '.$homepage->getTweetLink($retweet['status']).'
											 </div>
                                             - '.((empty($retweet["tweet_image"]) == 1)?'':'<img width="200px" src="'.BASE_URL.$retweet["tweet_image"].'" />').'
                						 </div>
                					 </div>
                				</div>
                			</div>
                		</div>
                		<div class="retweet-popup-footer"> 
                			<div class="retweet-popup-footer-right">
                				<button class="retweet-it" type="submit"><i class="fa fa-retweet" aria-hidden="true"></i>Retweet</button>
                			</div>
                		</div>
                	</div>
                </div>
                </div> ';

	 }
?>
