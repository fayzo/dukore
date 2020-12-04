<?php 
session_start();
include('../init.php');
$users->preventUsersAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

if (isset($_POST['showpimage']) && !empty($_POST['showpimage'])) {
    $user_id= $_SESSION['user_id'];
    $tweet_id=$_POST['showpimage'];
    $getid="";
    $tweet= $homepage->getPopupTweet($user_id,$tweet_id,$getid);
    $tweet_likes= $homepage->likes($user_id,$tweet_id);
    $Retweet= $homepage->checkRetweet($tweet_id, $user_id);
    $user= $users->userData($tweet_id); ?>

    <div class="img-popup">
        <div class="wrap6">
        <span class="colose">
        	<button class="close-imagePopup"><i class="fa fa-times" aria-hidden="true"></i></button>
        </span>
        <div class="img-popup-wrap">
        	<div class="img-popup-body">
        		<img src="<?php echo BASE_URL.$tweet['tweet_image'];?>"/>
        	</div>
        	<div class="img-popup-footer">
        		<div class="img-popup-tweet-wrap">
        			<div class="img-popup-tweet-wrap-inner">
        				<div class="img-popup-tweet-left">
        					<img src="<?php echo BASE_URL.$tweet['profile_image'];?>"/>
        				</div>
        				<div class="img-popup-tweet-right">
        					<div class="img-popup-tweet-right-headline">
        						<a href="<?php echo BASE_URL. $tweet['username'];?>"><?php echo $tweet['screenname'];?></a><span>@<?php echo $tweet['username'];?> - <?php echo $homepage->timeAgo($tweet['posted_on']);?></span>
        					</div>
        					<div class="img-popup-tweet-right-body">
        						<?php echo $homepage->getTweetLink($tweet['status']);?>
        					</div>
        				</div>
        			</div>
        		</div>
        		<div class="img-popup-tweet-menu">
        			<div class="img-popup-tweet-menu-inner">
        			  	<ul> 
                          <?php 
                          if ($users->loggedin() === true) {
                              echo '
                             <li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>	
                             <li>'.(($tweet['tweet_id'] == $Retweet["retweet_id"])? '<button class="retweeted" data-tweet="'.$tweet["tweet_id"].'"  data-user="'.$tweet["tweetBy"].'" ><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetcounter" >'.$Retweet["retweet_counts"].'</span></button>':'<button class="retweet" data-tweet="'.$tweet["tweet_id"].'"  data-user="'.$tweet["tweetBy"].'" ><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetcounter" >'.(($Retweet["retweet_counts"] > 0)? $Retweet["retweet_counts"] :'' ).'</span></button>').'</li>
                             <li>'.(($tweet_likes["like_on"] == $tweet["tweet_id"])? '<button class="unlike-btn" data-tweet="'.$tweet["tweet_id"].'"  data-user="'.$tweet["tweetBy"].'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likescounter" >'.$tweet["likes_counts"].'</span></button> ' : '<button class="like-btn" data-tweet="'.$tweet["tweet_id"].'"  data-user="'.$tweet["tweetBy"].'"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likescounter" >'.(($tweet["likes_counts"] > 0)? $tweet["likes_counts"]:'' ).'</span></button> ').'</li>
                             '.(($tweet["tweetBy"] == $user_id)?'
                             <li><label for="img-popup-menu"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></label>
        				 	 <input id="img-popup-menu" type="checkbox"/>
        					 <div class="img-popup-footer-menu">
        						<ul>
        						  <li><label class="deleteTweet" data-tweet="'.$tweet["tweet_id"].'" >Delete Tweet</label></li>
        						</ul>
        					 </div>
							 </li>':'').' 
							 ';

                          }else {
                              # code...
                              echo '
                              <li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>	
                              <li><button class="retweet"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount"></span></button></li>
                              <li><button class="like-btn"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter"></span></button></li>
                              ';
                          }
                          ?>
        					<!-- <li><label for="img-popup-menu"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></label>
        					<input id="img-popup-menu" type="checkbox"/>
        					<div class="img-popup-footer-menu">
        						<ul>
        						  <li><label class="deleteTweet" >Delete Tweet</label></li>
        						</ul>
        					</div>
        					</li> -->
        				</ul>
        			</div>
        		</div>
        	</div>
        </div>
        </div>
        </div><!-- Image PopUp ends-->


<?php  

}?>

