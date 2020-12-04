<?php 
session_start();
include('../init.php');
$users->preventUsersAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

if (isset($_POST['comments']) && !empty($_POST['comments'])) {
    $user_id= $_SESSION['user_id'];
    $tweet_id= $_POST['tweet_id'];
    $commentz= $users->test_input($_POST['comments']);

    if (!empty($commentz)) {
        # code...
        $homepage->creates('comment',array('comment' => $commentz,'comment_on' => $tweet_id,'comment_by' => $user_id,'comment_at' => date('Y-m-d H:i:s')));
        $commentx= $comment->comments($tweet_id);
        $tweet= $homepage->getPopupTweet($user_id,$tweet_id,$commentz);
		 # code..
		  foreach ($commentx as $comments) {
            # code...

	     echo '
	     <div class="tweet-show-popup-comment-box">
            <div class="tweet-show-popup-comment-inner">
            	<div class="tweet-show-popup-comment-head">
            		<div class="tweet-show-popup-comment-head-left">
            			 <div class="tweet-show-popup-comment-img">
            			 	 '.((!empty($comments["profile_image"])?'
							  <img src="'.BASE_URL.$comments["profile_image"].'">
							  ':'
							  <img src="'.BASE_URL.NO_PROFILE_IMAGE_URL.'">
							  ')).'
            			 </div>
            		</div>
            		<div class="tweet-show-popup-comment-head-right">
            			  <div class="tweet-show-popup-comment-name-box">
            			 	<div class="tweet-show-popup-comment-name-box-name"> 
            			 		<a href="'.BASE_URL.'profile.php?username='.$comments["username"].'">'.$comments["screenname"].'</a>
            			 	</div>
            			 	<div class="tweet-show-popup-comment-name-box-tname">
            			 		<a href="'.BASE_URL.'profile.php?username='.$comments["username"].'">@'.$comments["username"].' - '.$homepage->timeAgo($comments["comment_at"]).'</a>
            			 	</div>
            			 </div>
            			 <div class="tweet-show-popup-comment-right-tweet">
            			 		<p><a href="'.BASE_URL.'profile.php?username='.$comments["username"].'">@'.$tweet["username"].'</a> '.$comments["comment"].'</p>
            			 </div>
            		 	<div class="tweet-show-popup-footer-menu">
            				<ul>
            					<li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>
            					<li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li>
            					'.(($comments["comment_by"] === $user_id)?'
							    <li>
                        	       <a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
							       <ul> 
                        	         <li><label class="deleteComment" data-tweet="'.$tweet["tweet_id"].'" data-comment="'.$comments["comment_id"].'" >Delete Tweet</label></li>
                        	       </ul>
							    </li>
							    ':'').'
            				</ul>
            			</div>
            		</div>
            	</div>
            </div>
            <!--TWEET SHOW POPUP COMMENT inner END-->
		  </div> ';
        }

    }
}
?>