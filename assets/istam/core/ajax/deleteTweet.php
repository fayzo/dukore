<?php 
session_start();
include('../init.php');
$users->preventUsersAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

if (isset($_POST['deleteTweetHome']) && !empty($_POST['deleteTweetHome'])) {
    $user_id= $_SESSION['user_id'];
	$tweet_id= $_POST['deleteTweetHome'];
    $comment->delete('tweety',array('tweet_id' => $tweet_id,'tweetBy' => $user_id));
}

if (isset($_POST['showpopupdelete']) && !empty($_POST['showpopupdelete'])) {
    $user_id= $_SESSION['user_id'];
	$tweet_id= $_POST['showpopupdelete'];
	$deleteTweet_id= $_POST['deleteTweet'];
    $tweet=$homepage->getPopupTweet($user_id,$tweet_id,$deleteTweet_id);
    ?>
    <div class="retweet-popup">
      <div class="wrap5">
        <div class="retweet-popup-body-wrap">
          <div class="retweet-popup-heading">
            <h3>Are you sure you want to delete this Tweet?</h3>
            <span><button class="close-retweet-popup"><i class="fa fa-times" aria-hidden="true"></i></button></span>
          </div>
           <div class="retweet-popup-inner-body">
            <div class="retweet-popup-inner-body-inner">
              <div class="retweet-popup-comment-wrap">
                 <div class="retweet-popup-comment-head">
                 <?php if (!empty($tweet['profile_image'])) {?>
                     <!-- # code... -->
                     <img src="<?php echo BASE_URL.$tweet['profile_image'];?>"/>
                <?php }else {?>
                    <!-- # code... -->
                     <img src="<?php echo BASE_URL.NO_PROFILE_IMAGE_URL;?>"/>
                <?php }?>
                 </div>
                 <div class="retweet-popup-comment-right-wrap">
                   <div class="retweet-popup-comment-headline">
                    <a><?php echo $tweet['screenname'];?> </a><span>‏@<?php echo $tweet['username'];?>  -<?php echo $homepage->timeAgo($tweet['posted_on']);?></span>
                   </div><br>
                   <div class="retweet-popup-comment-body">
                       <div class="t-h-c-dis">
                           <?php echo $homepage->getTweetLink($tweet['status']).
                       '</div> <br>
                           '.((!empty($tweet['tweet_image'])) ?'<img src="'.BASE_URL.$tweet['tweet_image'].'" />':'').'
                           ';?>
                   </div>
                 </div>
              </div>
             </div>
          </div>
          <div class="retweet-popup-footer"> 
            <div class="retweet-popup-footer-right">
              <button class="cancel-it f-btn">Cancel</button><button class="delete-it" type="submit">Delete</button>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php
}
?>