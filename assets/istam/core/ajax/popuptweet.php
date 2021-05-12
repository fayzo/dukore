<?php 
session_start();
include('../init.php');
$users->preventUsersAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

if (isset($_POST['showpoptweet']) && !empty($_POST['showpoptweet'])) {
    $user_id= $_SESSION['user_id'];
    $tweet_id= $_POST['showpoptweet'];
    $getid="";
    $tweet= $homepage->getPopupTweet($user_id,$tweet_id,$getid);
    $tweet_likes= $homepage->likes($user_id,$tweet_id);
    $Retweet= $homepage->checkRetweet($tweet_id, $user_id);
	  $user= $users->userData($tweet_id);
	  $comment_= $comment->comments($tweet_id);
    ?>

    <div class="tweet-show-popup-wrap">
        <input type="checkbox" id="tweet-show-popup-wrap">
        <div class="wrap4">
        	<label for="tweet-show-popup-wrap">
        		<div class="tweet-show-popup-box-cut">
        			<i class="fa fa-times" aria-hidden="true"></i>
        		</div>
        	</label>
        	<div class="tweet-show-popup-box">
        	<div class="tweet-show-popup-inner">
        		<div class="tweet-show-popup-head">
        			<div class="tweet-show-popup-head-left">
        				<div class="tweet-show-popup-img">
                            <?php if (!empty($tweet['profile_image'])) {?>
        				              <img src="<?php echo BASE_URL. $tweet['profile_image'];?>"/>
                              <?php }else {?>
                                      <img src="<?php echo BASE_URL.NO_PROFILE_IMAGE_URL ;?>" />
                             <?php }?>
        				</div>
        				<div class="tweet-show-popup-name">
        					<div class="t-s-p-n">
        						<a href="<?php echo BASE_URL.$tweet['username'];?>">
        							<?php echo $tweet['screenname'];?>
        						</a>
        					</div>
        					<div class="t-s-p-n-b">
        						<a href="<?php echo BASE_URL.$tweet['username'];?>">
        							@<?php echo $tweet['username'];?>
        						</a>
        					</div>
        				</div>
        			</div>
        			<div class="tweet-show-popup-head-right">
        				  <button class="f-btn"><i class="fa fa-user-plus"></i> Follow </button>
        			</div>
        		</div>
        		<div class="tweet-show-popup-tweet-wrap">
        			<div class="tweet-show-popup-tweet">
        				<?php echo $homepage->getTweetLink($tweet['status']);?>
        			</div>
        			<div class="tweet-show-popup-tweet-ifram">
                        <?php 
                             if (!empty($tweet['tweet_image'])) {?>
                               <img src="<?php echo BASE_URL.$tweet['tweet_image'];?>"/> 
                        <?php } ?>
        			</div>
        		</div>
        		<div class="tweet-show-popup-footer-wrap">
        			<div class="tweet-show-popup-retweet-like">
        				<div class="tweet-show-popup-retweet-left">
        					<div class="tweet-retweet-count-wrap">
        						<div class="tweet-retweet-count-head">
        							RETWEET
        						</div>
        						<div class="tweet-retweet-count-body">
        							<?php echo $tweet['retweet_counts'];?>
        						</div>
        					</div>
        					<div class="tweet-like-count-wrap">
        						<div class="tweet-like-count-head">
        							LIKES
        						</div>
        						<div class="tweet-like-count-body">
        							<?php echo $tweet['likes_counts'];?>
        						</div>
        					</div>
        				</div>
        				<div class="tweet-show-popup-retweet-right">
        				 
        				</div>
        			</div>
        			<div class="tweet-show-popup-time">
        				<span><?php echo $homepage->timeAgo($tweet['posted_on']);?></span>
        			</div>
        			<div class="tweet-show-popup-footer-menu">
        				<ul>
                        <?php 
                        if ($users->loggedin() === true) {
                           echo '
                            <li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>	
                            <li>'.(($tweet['tweet_id'] == $Retweet["retweet_id"])? '<button class="retweeted" data-tweet="'.$tweet["tweet_id"].'"  data-user="'.$tweet["tweetBy"].'" ><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetcounter" >'.$Retweet["retweet_counts"].'</span></button>':'<button class="retweet" data-tweet="'.$tweet["tweet_id"].'"  data-user="'.$tweet["tweetBy"].'" ><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetcounter" >'.(($Retweet["retweet_counts"] > 0)? $Retweet["retweet_counts"] :'' ).'</span></button>').'</li>
                            <li>'.(($tweet_likes["like_on"] == $tweet["tweet_id"])? '<button class="unlike-btn" data-tweet="'.$tweet["tweet_id"].'"  data-user="'.$tweet["tweetBy"].'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likescounter" >'.$tweet["likes_counts"].'</span></button> ' : '<button class="like-btn" data-tweet="'.$tweet["tweet_id"].'"  data-user="'.$tweet["tweetBy"].'"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likescounter" >'.(($tweet["likes_counts"] > 0)? $tweet["likes_counts"]:'' ).'</span></button> ').'</li>
							'.(($tweet["tweetBy"] === $user_id)?'
							<li>
                            	<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                            	<ul> 
                            	  <li><label class="deleteTweet" data-tweet="'.$tweet["tweet_id"].'"  data-user="'.$tweet["tweetBy"].'" >Delete Tweet</label></li>
                            	</ul>
                            </li>':'').'
                           ';
                        }else {?>
        					<li><button type="buttton"><i class="fa fa-share" aria-hidden="true"></i></button></li>
        					<li><button type="button"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">RETWEET-COUNT</span></button></li>
        					<li><button type="button"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCount">LIKES-COUNT</span></button></button></li>
        					<li>
        					<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
        						<ul> 
        							<li><label class="deleteTweet" >Delete Tweet</label></li>
        						</ul>	
        					</li>
                         <?php } ?>
        				</ul>
        			</div>
        		</div>
        	</div><!--tweet-show-popup-inner end-->
           <?php if ($users->loggedin() === true) {?>

         	<div class="tweet-show-popup-footer-input-wrap">
        		<div class="tweet-show-popup-footer-input-inner">
        			<div class="tweet-show-popup-footer-input-left">
                      <?php if (!empty($user['profile_image'])) {?>
        				<img src="<?php echo BASE_URL.$user['profile_image'];?>"/>
                      <?php }else {?>
                          <img src="<?php echo BASE_URL.NO_PROFILE_IMAGE_URL ;?>" />
                     <?php }?>
        			</div>
        			<div class="tweet-show-popup-footer-input-right">
        				<input id="commentField" type="text" name="comment" data-tweet="<?php echo $tweet['tweet_id'];?>" placeholder="Reply to @<?php echo $tweet['username'] ;?>">
        			</div>
        		</div>
        		<div class="tweet-footer">
        		 	<div class="t-fo-left">
        		 		<ul>
        		 			<li>
        		 				<!-- <label for="t-show-file"><i class="fa fa-camera" aria-hidden="true"></i></label>
        		 				<input type="file" id="t-show-file"> -->
        		 			</li>
        		 			<li class="error-li">
        				    </li> 
        		 		</ul>
        		 	</div>
        		 	<div class="t-fo-right">
         		 		<input type="submit" id="postComment" value="Tweet">
        		 	</div>
        		 </div>
        	</div><!--tweet-show-popup-footer-input-wrap end-->
         <?php  } ?>
        <div class="tweet-show-popup-comment-wrap">
        	<div id="comments">
        	 	<!--COMMENTS--> 
				 <?php 
		          foreach ($comment_ as $comments) {

					 # code..
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
                        			 		<a href="'.BASE_URL.$comments["username"].'">'.$comments["screenname"].'</a>
                        			 	</div>
                        			 	<div class="tweet-show-popup-comment-name-box-tname">
                        			 		<a href="'.BASE_URL.$comments["username"].'">@'.$comments["username"].' - '.$homepage->timeAgo($comments["comment_at"]).'</a>
                        			 	</div>
                        			 </div>
                        			 <div class="tweet-show-popup-comment-right-tweet">
                        			 		<p><a href="'.BASE_URL.$comments["username"].'">@'.$tweet["username"].'</a> '.$comments["comment"].'</p>
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
				 ?>
        	</div>
        
        </div>
        <!--tweet-show-popup-box ends-->
        </div>
    </div>

<?php }
?>