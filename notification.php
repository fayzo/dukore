<?php
session_start();
include('core/init.php');

if ($users->loggedin() == false) {
	header('location: '.BASE_URL.'index.php');
}

$user_id=$_SESSION['user_id'];
$user=$users->userData($user_id);
$notific= $notification->getNotificationCount($user_id);
$notification->notificationsView($user_id);

if (isset($_POST['tweet'])) {
	# code...
	$status= $homepage->test_input($_POST['status']);
	$files= $_FILES['file'];

	if (!empty($status) || !empty($files)) {
		if (!empty($files)) {
			# code...
			$tweetimages = $homepage->uploadImageProfiles($files);
		}

		if (strlen($status) > 140) {
			$errror= "The text is too long";
		}
		$tweet_id= $homepage->creates('Tweety',array('status' => $status, 'tweetBy' => $user_id, 'tweet_image' => $tweetimages, 'posted_on' => date('Y-m-d H-i-s')));
		preg_match_all("/#+([a-zA-Z0-9_]+)/i",$status, $hashtag);
		if (!empty($hashtag)) {
			# code...
			$homepage->addTrends($status);
		}
		$homepage->addmention($status,$user_id,$tweet_id);
		# code...
	}else {
		# code...
		$error= "Type or choose image to tweet";
	}

}
?>
<!--
   This template created by Meralesson.com 
   This template only use for educational purpose 
-->
<!DOCTYPE HTML> 
 <html>
	<head>
		<title><?php echo $user['screenname'].' @'.$user['username'].' Notification';?></title>
		  <meta charset="UTF-8" />
		   <meta http-equiv="X-UA-Compatible" content="IE=edge">
           <meta name="viewport" content="width=device-width, initial-scale=1">
	      <link rel="stylesheet" href="<?php echo BASE_URL ;?>assets/css/font/css/font-awesome.min.css"/>
		  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>   -->
 	  	  <link rel="stylesheet" href="<?php echo BASE_URL ;?>assets/css/style-complete.css"/> 
		  <!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>  	   -->
	</head>
	<!--Helvetica Neue-->
<body style="margin-top:100px;">
<div class="wrapper">
<!-- header wrapper -->
<div class="header-wrapper">

<div class="nav-container">
	<!-- Nav -->
	<div class="nav">
		
		<div class="nav-left">
		    <ul>
				<li><a href="<?php echo BASE_URL ;?>home"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
				<li><a href="<?php echo BASE_URL ;?>i.notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notification<span id="notification"><?php if( $notific['totalnotification'] > 0){echo '<span class="span-i">'.$notific['totalnotification'].'</span>'; } ?></span></a></li>
				<li id='messagePopup'><i class="fa fa-envelope" aria-hidden="true"></i>Messages<span id="messages"><?php if( $notific['totalmessage'] > 0){echo '<span class="span-i">'.$notific['totalmessage'].'</span>'; } ?></span></li>
			</ul>
		</div><!-- nav left ends-->
    
		<div class="nav-right">
			<ul>
				<li>
					<input type="text" placeholder="Search" class="search" />
					<i class="fa fa-search" aria-hidden="true"></i>
					<div class="search-result">			
					</div>
				</li>
				<?php if (isset($user_id) == $user['user_id']  && empty($user['profile_image']) == 1) {
		        	# code...
					   echo '<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="'.BASE_URL.NO_PROFILE_IMAGE_URL.'" /></label>';
					  
		        }elseif (isset($user_id) == $user['user_id']  && !empty($user['profile_image']) == $user['profile_image']) {
		        	# code...
					   echo '<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="'.BASE_URL.$user["profile_image"].'"/></label>';
		        }
		        ?>

				<input type="checkbox" id="drop-wrap1">
				<div class="drop-wrap">
					<div class="drop-inner">
						<ul>
							<li><a href="<?php echo BASE_URL.$user['username'] ;?>"><?php echo $user['username'] ;?></a></li>
							<li><a href="<?php echo BASE_URL;?>settings.account">Settings</a></li>
							<li><a href="<?php echo BASE_URL;?>include.logout">Log out</a></li>
						</ul>
					</div>
				</div>
				</li>
				<li><label class="addTweetBtn">Tweet</label></li>
			</ul>
		</div><!-- nav right ends-->

	</div><!-- nav ends -->

</div><!-- nav container ends -->

</div><!-- header wrapper end -->

<!---Inner wrapper-->
<div class="inner-wrapper">
<div class="in-wrapper">
	<div class="in-full-wrap">
		<div class="in-left">
			<div class="in-left-wrap">
		<div class="info-box">
			<div class="info-inner">
				<div class="info-in-head">
					<!-- PROFILE-COVER-IMAGE -->
					<?php if (isset($user_id) == $user['user_id']  && empty($user['profile_cover']) == 1) {
		            	# code...
				    	   echo '<img src="'.BASE_URL.NO_COVER_IMAGE_URL.'" />';
				    	  
		            }elseif (isset($user_id) == $user['user_id']  && !empty($user['profile_cover']) == $user['profile_cover']) {
		            	# code...
				    	   echo '<img src="'.BASE_URL.$user["profile_cover"].'"/>';
		            }
		            ?>
				</div><!-- info in head end -->
				<div class="info-in-body">
					<div class="in-b-box">
						<div class="in-b-img">
						<!-- PROFILE-IMAGE -->
						<?php if (isset($user_id) == $user['user_id']  && empty($user['profile_image']) == 1) {
		                	# code...
				        	   echo '<img src="'.BASE_URL.NO_PROFILE_IMAGE_URL.'" />';
				        	  
		                }elseif (isset($user_id) == $user['user_id']  && !empty($user['profile_image']) == $user['profile_image']) {
		                	# code...
				        	   echo '<img src="'.BASE_URL.$user["profile_image"].'"/>';
		                }
		                ?>
						</div>
					</div><!--  in b box end-->
					<div class="info-body-name">
						<div class="in-b-name">
							<div><a href="<?php echo BASE_URL.$user['username'] ;?>" ><?php echo $user['screenname'] ;?></a></div>
							<span><small><a href="<?php echo  BASE_URL.$user['username'] ;?>">@<?php echo $user['username'] ;?></a></small></span>
						</div><!-- in b name end-->
					</div><!-- info body name end-->
				</div><!-- info in body end-->
				<div class="info-in-footer">
					<div class="number-wrapper">
						<div class="num-box">
							<div class="num-head">
								TWEETS
							</div>
							<div class="num-body">
								<?php echo $homepage->countsTweet($user_id) ;?>
							</div>
						</div>
						<div class="num-box">
							<div class="num-head">
								FOLLOWING
							</div>
							<div class="num-body">
								<span class="count-following"><?php echo $user['following'] ;?></span>
							</div>
						</div>
						<div class="num-box">
							<div class="num-head">
								FOLLOWERS
							</div>
							<div class="num-body">
								<span class="count-followers"><?php echo $user['followers'] ;?></span>
							</div>
						</div>	
					</div><!-- mumber wrapper-->
				</div><!-- info in footer -->
			</div><!-- info inner end -->
		</div><!-- info box end-->

	<!--==TRENDS==-->
 	  <!---TRENDS HERE-->
	   <?php $trending->trends() ; ?>
 	<!--==TRENDS==-->

	</div><!-- in left wrap-->
		</div><!-- in left end-->
		<div class="in-center">
			<div class="in-center-wrap">
				<!--TWEET WRAPPER TEXTAREA here-->
                                    
                    <!--NOTIFICATION WRAPPER FULL WRAPPER-->
                    <div class="notification-full-wrapper">
                    
                    	<div class="notification-full-head">
                    		<div>
                    			<a href="#">All</a>
                    		</div>
                    		<div>
                    			<a href="#Mention">Mention</a>
                    		</div>
                    		<div>
                    			<a href="#">settings</a>
                    		</div>
                    	</div>
                    <?php 
                    $notif= $notification->notifications($user_id);
                    // var_dump($notif);
                    foreach ($notif as $data): 
                            if ($data['type'] == 'follow'):
                        ?>

                    <!-- Follow Notification -->
                    <!--NOTIFICATION WRAPPER-->
                    <div class="notification-wrapper">
                    	<div class="notification-inner">
                    		<div class="notification-header">
                    			
                    			<div class="notification-img">
                    				<span class="follow-logo">
                    					<i class="fa fa-child" aria-hidden="true"></i>
                    				</span>
                    			</div>
                    			<div class="notification-name">
                    				<div>
                                     <?php 
                                     if (!empty($data['profile_image'])) { ?>
                    					 <img src="<?php echo BASE_URL.$data['profile_image'] ;?>"/>
                                     <?php }else {?>
                    					 <img src="<?php echo BASE_URL.NO_COVER_IMAGE_URL ;?>"/>
                                    <?php } ?>
                    				</div>
                    			 
                    			</div>
                    			<div class="notification-tweet"> 
                    			<a href="<?php echo BASE_URL.$data['username'] ;?>" class="notifi-name"><?php if (!empty($data['screenname'])) { echo $data['screenname']; }else{ echo '@'.$data['username']; } ?></a><span> Followed you on - <span><?php echo $users->timeAgo($data['follow_on']) ;?></span>
                    			
                    			</div>
                    		
                    		</div>
                    		
                    	</div>
                    	<!--NOTIFICATION-INNER END-->
                    </div>
                    <!--NOTIFICATION WRAPPER END-->
                    <!-- Follow Notification -->
                    <?php  endif; 

                     if ($data['type'] == 'likes'):
                    ?>
                    <!-- Like Notification -->
                    <!--NOTIFICATION WRAPPER-->
                    <div class="notification-wrapper">
                    	<div class="notification-inner">
                    		<div class="notification-header">
                    			<div class="notification-img">
                    				<span class="heart-logo">
                    					<i class="fa fa-heart" aria-hidden="true"></i>
                    				</span>
                    			</div>
                    			<div class="notification-name">
                    				<div>
                    					 <img src="<?php echo BASE_URL.$data['profile_image'] ;?>"/>
                    				</div>
                    			</div>
                    		</div>
                    		<div class="notification-tweet"> 
                    			<a href="<?php echo BASE_URL.$data['username'] ;?>" class="notifi-name"><?php if (!empty($data['screenname'])) { echo $data['screenname']; }else{ echo '@'.$data['username']; } ?></a><span> liked your<?php if ($data['tweetBy'] == $user_id) {echo 'Tweet'; }else{echo 'ReTweet';} ?> - <span><?php echo $users->timeAgo($data['posted_on']) ;?></span>
                    		</div>
                    		<div class="notification-footer">
                    			<div class="noti-footer-inner">
                    				<div class="noti-footer-inner-left">
                    					<div class="t-h-c-name">
                    						<span><a href="<?php echo BASE_URL.$user['username'] ;?>"><?php echo $user['screenname'] ;?></a></span>
                    						<span>@<?php echo $user['username'] ;?></span>
                    						<span><?php echo $users->timeAgo($data['posted_on']) ;?></span>
                    					</div>
                    					<div class="noti-footer-inner-right-text">		
                    						<?php echo $homepage->getTweetLink($data['status']) ;?>
                    					</div>
                    				</div>
									<?php if (!empty($data['tweet_image'])) {?>
                    				<div class="noti-footer-inner-right">
                    					<img src="<?php echo BASE_URL.$data['tweet_image'] ;?>"/>	
                    				</div> 
									<?php } ?>
                    
                    			</div><!--END NOTIFICATION-inner-->
                    		</div>
                    	</div>
                    </div>
                    <!--NOTIFICATION WRAPPER END--> 
                    <!-- Like Notification -->
                     <?php  endif; 
                     
					 if ($data['type'] == 'retweet'):
                     ?>
                    <!-- Retweet Notification -->
                    <!--NOTIFICATION WRAPPER-->
                    <div class="notification-wrapper">
                    	<div class="notification-inner">
                    		<div class="notification-header">
                    			
                    			<div class="notification-img">
                    				<span class="retweet-logo">
                    					<i class="fa fa-retweet" aria-hidden="true"></i>
                    				</span>
                    			</div>
                    		<div class="notification-tweet"> 
                    			<a href="<?php echo BASE_URL.$data['username'] ;?>" class="notifi-name"><?php if (!empty($data['screenname'])) { echo $data['screenname']; }else{ echo '@'.$data['username']; } ?></a><span> retweet your <?php if ($data['tweetBy'] == $user_id) {echo 'Tweet'; }else{echo 'ReTweet';} ?>- <span><?php echo $users->timeAgo($data['posted_on']) ;?></span>
                    		</div>
                    		<div class="notification-footer">
                    			<div class="noti-footer-inner">
                    
                    				<div class="noti-footer-inner-left">
                    					<div class="t-h-c-name">
                    						<span><a href="<?php echo BASE_URL.$user['username'] ;?>"><?php echo $user['screenname'] ;?></a></span>
                    						<span>@<?php echo $user['username'] ;?></span>
                    						<span><?php echo $users->timeAgo($data['posted_on']) ;?></span>
                    					</div>
                    					<div class="noti-footer-inner-right-text">		
                    						<?php echo $homepage->getTweetLink($data['status']) ;?>
                    					</div>
                    				</div>
                    			 
                    		        <?php if (!empty($data['tweet_image'])) {?>
                    				    <div class="noti-footer-inner-right">
                    				    	<img src="<?php echo BASE_URL.$data['tweet_image'] ;?>"/>	
                    				    </div> 
									<?php } ?>
                    
                    			</div><!--END NOTIFICATION-inner-->
                    		</div>
                    		</div>
                    	</div>
                    </div>
                    <!--NOTIFICATION WRAPPER END-->
                    <!-- Retweet Notification -->
                   <?php 
				   endif; 
			if ($data['type'] == 'mention'):
			$tweet= $data;
			$tweet_likes= $homepage->likes($user_id,$tweet['tweet_id']);
            $Retweet= $homepage->checkRetweet($tweet['tweet_id'], $user_id);
			# code...
			echo '<div id="Mention">';
			
            echo '<div class="all-tweet-inner" style="margin-bottom:10px;">
                    <div class="t-show-wrap">	
                     <div class="t-show-inner">

                    	<div class="t-show-popup" data-tweet="'.$tweet["tweet_id"].'">
                    		<div class="t-show-head">
                                <div class="t-show-img">
                                   '.((empty($tweet['profile_image']))?
	 	                           '<img src="'.BASE_URL.NO_PROFILE_IMAGE_URL.'" />':'<img src="'.BASE_URL.$tweet["profile_image"].'"/>').'
                    			</div>
                    			<div class="t-s-head-content">
                    				<div class="t-h-c-name">
                    					<span><a href="'.BASE_URL.'profile.php?username='.$tweet["username"].'">'.$tweet["screenname"].'</a></span>
                    					<span>@'.$tweet["username"].'</span>
                    					<span>'.$homepage->timeAgo($tweet["posted_on"]).'</span>
                                    </div>
                                    <div class="t-h-c-dis">
                                      '.$homepage->getTweetLink($tweet["status"]).'
				                    </div>
                    				<div class="t-h-c-dis">
                    				</div>
                    			</div>
                            </div>'.
                           ((!empty($tweet['tweet_image']))?
                                  '
                    		          <!--tweet show head end-->
                    		          <div class="t-show-body">
                    		            <div class="t-s-b-inner">
                    		             <div class="t-s-b-inner-in">
                    		               <img src="'.BASE_URL.$tweet["tweet_image"].'" class="imagePopup" data-tweet="'.$tweet["tweet_id"].'" />
                    		             </div>
                    		            </div>
                    		          </div>
                                      <!--tweet show body end--> 
                               ':'').'

								 </div>
								 
                                	<div class="t-show-footer">
                                		<div class="t-s-f-right">
											<ul> 
											    '.(($users->loggedin() == true )?'
                                                <li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>	
                                                <li>'.(($tweet['tweet_id'] == $Retweet["retweet_id"] || $user_id == $Retweet['retweet_by'])? '<button class="retweeted" data-tweet="'.$tweet["tweet_id"].'"  data-user="'.$tweet["tweetBy"].'" ><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetcounter" >'.$Retweet["retweet_counts"].'</span></button>':'<button class="retweet" data-tweet="'.$tweet["tweet_id"].'"  data-user="'.$tweet["tweetBy"].'" ><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetcounter" >'.(($Retweet["retweet_counts"] > 0)? $Retweet["retweet_counts"] :'' ).'</span></button>').'</li>
                                                <li>'.(($tweet_likes["like_on"] == $tweet["tweet_id"])? '<button class="unlike-btn" data-tweet="'.$tweet["tweet_id"].'"  data-user="'.$tweet["tweetBy"].'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likescounter" >'.$tweet["likes_counts"].'</span></button> ' : '<button class="like-btn" data-tweet="'.$tweet["tweet_id"].'"  data-user="'.$tweet["tweetBy"].'"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likescounter" >'.(($tweet["likes_counts"] > 0)? $tweet["likes_counts"]:'' ).'</span></button> ').'</li>
                                                '.(($tweet["tweetBy"] == $user_id)?'
											    <li>
                        					       <a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
											       <ul> 
                        					         <li><label class="deleteTweet" data-tweet="'.$tweet["tweet_id"].'" data-user="'.$tweet["tweetBy"].'" >Delete Tweet</label></li>
                        					       </ul>
											    </li> ':'').'
												':'
												<li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>	
                                                <li><button><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a></button></li>	
                                                <li><button><a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a></button></li>	
												
												').'
                                			</ul>
                                		</div>
                                	</div>
                                 </div>
                                </div>
                              </div> ';

					echo '</div>';
                    endif; 

                    endforeach; ?>
                    
                    </div>
                    <!--NOTIFICATION WRAPPER FULL WRAPPER END-->

 				<!--TWEETS SHOW WRAPPER-->

		    	<div class="loading-div">
		    		<img id="loader" src="<?php echo BASE_URL ;?>assets/images/loading.svg" style="display: none;"/> 
		    	</div>
				<div class="popupTweet"></div>
				<!--Tweet END WRAPER-->
 			
			</div><!-- in left wrap-->
		</div><!-- in center end -->

		<div class="in-right">
			<div class="in-right-wrap">

		 	<!--Who To Follow-->
		      <!--WHO_TO_FOLLOW HERE-->
				<?php $follow->whoTofollow($user_id); ?>

      		<!--Who To Follow-->

 			</div><!-- in left wrap-->

		</div><!-- in right end -->

	</div><!--in full wrap end-->

</div><!-- in wrappper ends-->
</div><!-- inner wrapper ends-->
</div><!-- ends wrapper -->
    <script src="<?php echo BASE_URL;?>assets/js/jquery.min.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/popper.min.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/search.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/hashtag.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/likes.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/retweet.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/popuptweet.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/comment.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/deletecomment.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/popupTweetForm.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/fetch_home.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/follow.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/message.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/postmessage.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/notification.js"></script>

<?php echo $db->closeDb(); ?>
</body>
</html>