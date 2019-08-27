<?php
session_start();
include('core/init.php');

if ($users->loggedin() == false) {
	header('location: '.BASE_URL.'index.php');
}

if (isset($_GET['hashtag']) && !empty($_GET['hashtag'])) {
    $user_id= $_SESSION['user_id'];
    $hashtag= $users->test_input($_GET['hashtag']);
	$user= $users->userData($user_id);
	$notific= $notification->getNotificationCount($user_id);
	$notification->notificationsView($user_id);
}
?>

<!doctype html>
<html>
	<head>
		<title><?php echo '#'.$hashtag.' hashtag on tweety' ; ?></title>
		<meta charset="UTF-8" />
 		<link rel="stylesheet" href="<?php echo BASE_URL ;?>assets/css/style-complete.css"/>
         <link rel="stylesheet" href="<?php echo BASE_URL ;?>assets/css/font/css/font-awesome.min.css"/>
		  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>   -->
		<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>  	   -->

    </head>
<!--Helvetica Neue-->
<body>
<div class="wrapper">
<!-- header wrapper -->
<div class="header-wrapper">	
	<div class="nav-container">
    	<div class="nav">
		<div class="nav-left">
			<ul>
				<li><a href="<?php echo BASE_URL ;?>home"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
				<?php if ($users->loggedin() == true) {
					# code...
					?>
				<li><a href="<?php echo BASE_URL ;?>i.notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notification<span id="notification"><?php if( $notific['totalnotification'] > 0){echo '<span class="span-i">'.$notific['totalnotification'].'</span>'; } ?></span></a></li>
				<li id='messagePopup'><i class="fa fa-envelope" aria-hidden="true"></i>Messages<span id="messages"><?php if( $notific['totalmessage'] > 0){echo '<span class="span-i">'.$notific['totalmessage'].'</span>'; } ?></span></li>
				<?php }?>
				 
			</ul>
		</div><!-- nav left ends-->
		<div class="nav-right">
			<ul>
				<li><input type="text" placeholder="Search" class="search"/><i class="fa fa-search" aria-hidden="true"></i>
					<div class="search-result"> 			
					</div>
				</li>
			<?php if ($users->loggedin() == true) { ?>
				<?php if (isset($user_id) == $user['user_id']  && empty($user['profile_image']) == 1) {
	        		# code...
					  echo '<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="'.BASE_URL.NO_PROFILE_IMAGE_URL.'"/></label>';
	        	}elseif (isset($user_id) == $user['user_id']  && !empty($user['profile_image']) == $user['profile_image']) {
					# code...
					  echo '<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="'.BASE_URL.$user["profile_image"].'"/></label>';
				}
	        	?>
				<input type="checkbox" id="drop-wrap1">
				<div class="drop-wrap">
					<div class="drop-inner">
						<ul>
							<li><a href="<?php echo BASE_URL;?><?php echo $user['username'];?>"><?php echo $user['username'];?></a></li>
							<li><a href="<?php echo BASE_URL;?>settings.account">Settings</a></li>
							<li><a href="<?php echo BASE_URL;?>include.logout">Log out</a></li>
						</ul>
					</div>
				</div>
				</li>
				<li><label for="pop-up-tweet" class="addTweetBtn">Tweet</label></li>
				<?php 
				 }elseif (isset($user_id) == $user['user_id']  && !empty($user['profile_image']) == $user['profile_image']) {
	        		# code...
					  echo '<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="'.$user["profile_image"].'"/></label>
				            <li ><a href="'.BASE_URL.'index.php">Have an account? Log in</a></li>
					       ';
	        	 } ?>
			</ul>
		</div><!-- nav right ends-->

	</div><!-- nav ends -->
	</div><!-- nav container ends -->
</div><!-- header wrapper end -->

<!--#hash-header-->
<div class="hash-header">
	<div class="hash-inner">
		<h1><?php echo "#".$hashtag ;?></h1>
	</div>
</div>	
<!--#hash-header end-->

<!--hash-menu-->
<div class="hash-menu">
	<div class="hash-menu-inner">
		<ul>
 			<li><a href="<?php echo BASE_URL.$hashtag.'.latest.hashtag' ;?>">Latest</a></li>
			<li><a href="<?php echo BASE_URL.$hashtag.'.users.hashtag' ;?>">Accounts</a></li>
			<li><a href="<?php echo BASE_URL.$hashtag.'.photos.hashtag' ;?>">Photos</a></li>
  		</ul>
	</div>
</div>
<!--hash-menu-->
<!---Inner wrapper-->

<div class="in-wrapper">
	<div class="in-full-wrap">
		
		<div class="in-left">
			<div class="in-left-wrap">
			    <?php $follow->whoTofollow($user_id); ?>
			   <!-- Who TO Follow -->

			   <!--==TRENDS==-->
	 	    <!--Trends-->
	         <?php $trending->trends() ; ?>
	       	<!--==TRENDS==-->
			
			   
			</div>
			<!-- in left wrap-->
		</div>
		<!-- in left end-->
<?php 
if (strpos($_SERVER['REQUEST_URI'],'.photos')): 
	?>
<!-- TWEETS IMAGES  -->
 <div class="hash-img-wrapper"> 
 	<div class="hash-img-inner"> 
	 <?php 
	$tweets = $trending->getTweetsTrendbyhastag($hashtag);
	// echo var_dump($tweets);
	foreach ($tweets as $tweet) {
	  if (!empty($tweet['tweet_image'])) {
            # code...
		$tweet_likes = $homepage->likes($user_id, $tweet['tweet_id']);
		$Retweet = $homepage->checkRetweet($tweet['tweet_id'], $user_id);
		$user = $users->userData($tweet['retweet_by']);
		 # code...
		echo ' <div class="hash-img-flex">
		         	<img src="'.BASE_URL.$tweet['tweet_image'].'" class="imagePopup" data-tweet="'.$tweet['tweet_id']. '" />
		         	<div class="hash-img-flex-footer">
		         		<ul>
		         			' . (($users->loggedin() == true) ? '
                            <li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>	
                            <li>' . (($tweet['tweet_id'] == $Retweet["retweet_id"] || $user_id == $Retweet['retweet_by']) ? '<button class="retweeted" data-tweet="' . $tweet["tweet_id"] . '"  data-user="' . $tweet["tweetBy"] . '" ><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetcounter" >' . $Retweet["retweet_counts"] . '</span></button>' : '<button class="retweet" data-tweet="' . $tweet["tweet_id"] . '"  data-user="' . $tweet["tweetBy"] . '" ><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetcounter" >' . (($Retweet["retweet_counts"] > 0) ? $Retweet["retweet_counts"] : '') . '</span></button>') . '</li>
                            <li>' . (($tweet_likes["like_on"] == $tweet["tweet_id"]) ? '<button class="unlike-btn" data-tweet="' . $tweet["tweet_id"] . '"  data-user="' . $tweet["tweetBy"] . '"><i class="fa fa-heart" aria-hidden="true"></i><span class="likescounter" >' . $tweet["likes_counts"] . '</span></button> ' : '<button class="like-btn" data-tweet="' . $tweet["tweet_id"] . '"  data-user="' . $tweet["tweetBy"] . '"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likescounter" >' . (($tweet["likes_counts"] > 0) ? $tweet["likes_counts"] : '') . '</span></button> ') . '</li>
                            ' . (($tweet["tweetBy"] == $user_id) ? '
							<li>
                        	   <a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
							   <ul> 
                        	     <li><label class="deleteTweet" data-tweet="' . $tweet["tweet_id"] . '" data-user="' . $tweet["tweetBy"] . '" >Delete Tweet</label></li>
                        	   </ul>
							</li> ' : '') . '
							' : '
							<li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>	
                            <li><button><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a></button></li>	
                            <li><button><a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a></button></li>	
							
							') . '
		         		</ul>
		         	</div>
		        </div>';
			}else{
				echo '' ;
				// echo '<img src="'.BASE_URL.NO_PROFILE_IMAGE_URL.'" class="imagePopup"  />
				// ';
			} 
		}
		 ?>
	</div>
</div> 
<!-- TWEETS IMAGES -->
<?php 
elseif (strpos($_SERVER['REQUEST_URI'],'.users')):?>
<!--TWEETS ACCOUTS-->
<div class="wrapper-following">
   <div class="wrap-follow-inner">

        <?php 
        $account= $trending->getUsersHashtag($hashtag);
        foreach ($account as $acc) { ?>
         <div class="follow-unfollow-box">
        	<div class="follow-unfollow-inner">
        		<div class="follow-background">
				     <?php if (!empty($acc['profile_cover'])) { ?>
        		    	<img src="<?php echo BASE_URL.$acc['profile_cover']; ?>"/>
				     <?php }else{ ?>
        		    	<img src="<?php echo BASE_URL.NO_PROFILE_IMAGE_URL; ?>"/>
				     <?php } ?>
        		</div>
        		<div class="follow-person-button-img">
        			<div class="follow-person-img">
					     <?php if (!empty($acc['profile_image'])) { ?>
        		        	<img src="<?php echo BASE_URL.$acc['profile_image']; ?>"/>
				         <?php }else{ ?>
        		        	<img src="<?php echo BASE_URL.NO_PROFILE_IMAGE_URL; ?>"/>
				         <?php } ?>
        			</div>
        			<div class="follow-person-button">
        		    <?php echo $follow->followBtn($acc['user_id'], $user_id); ?>
        			</div>
        		</div>
        		<div class="follow-person-bio">
        			<div class="follow-person-name">
        				<a href="<?php echo BASE_URL . $acc['username']; ?>"><?php echo $acc['screenname']; ?></a>
        			</div>
        			<div class="follow-person-tname">
        				<a href="<?php echo BASE_URL . $acc['username']; ?>">@<?php echo $acc['username']; ?></a>
        			</div>
        			<div class="follow-person-dis">
        				<?php echo $homepage->getTweetLink($acc['bio']); ?>
        			</div>
        		</div>
        	</div>
        </div>
        <?php } ?>

      </div>
</div>
<!-- TWEETS ACCOUNTS -->
<?php 
else :	?>
	 <div class="in-center">
		<div class="in-center-wrap">
		<!-- TWEETS -->
	<?php 
	$tweets = $trending->getTweetsTrendbyhastag($hashtag);
	// echo var_dump($tweets);
	 foreach ($tweets as $tweet) {
            # code...
            $tweet_likes= $homepage->likes($user_id,$tweet['tweet_id']);
            $Retweet= $homepage->checkRetweet($tweet['tweet_id'], $user_id);
            $user= $users->userData($tweet['retweet_by']);
            # code...
            echo '<div class="all-tweet" style="margin-bottom:10px;">
                    <div class="t-show-wrap">	
                     <div class="t-show-inner">
                    	'.(($tweet['tweet_id'] == $tweet["retweet_id"]) || ($tweet["retweet_id"] > 0)?'
                    	<div class="t-show-banner">
                    		<div class="t-show-banner-inner">
                    			<span><i class="fa fa-retweet" aria-hidden="true"></i></span><span>'.$user['username'].'</span>
                    		</div>
                    	</div>
                        ':'').'

                        '.((!empty($tweet['retweet_msg']) && $tweet["tweet_id"] == $Retweet["tweet_id"] || $tweet["retweet_id"] > 0)?'
                        
                        <div class="t-show-popup" data-tweet="'.$tweet["tweet_id"].'">
                        <div class="t-show-head">
                             <div class="t-show-img">
                              '.((!empty($user['profile_image']))?
                                 '<img src="'.BASE_URL.$user['profile_image'].'"  />'
                                :' <img src="'.BASE_URL.NO_PROFILE_IMAGE_URL.'"  /> ').'
                             </div>
                         	<div class="t-s-head-content">
                         		<div class="t-h-c-name">
                         			<span><a href="'.BASE_URL.$user['username'].'">'.$user['username'].'</a></span>
                         			<span>@'.$user['username'].'</span>
                         			<span>'.$homepage->timeAgo($Retweet['posted_on']).'</span>
                         		</div>
                         		<div class="t-h-c-dis">
                         			'.$homepage->getTweetLink($tweet['retweet_msg']).'
                         		</div>
                         	</div>
                         </div>

                         <div class="t-s-b-inner">
                         	<div class="t-s-b-inner-in">
                                 <div class="retweet-t-s-b-inner">
                                    <div class="retweet-t-s-b-inner-left">
                                     '.((!empty($tweet['tweet_image'])?
                                       '<img src="'.BASE_URL.$tweet['tweet_image'].'" class="imagePopup" data-tweet="'.$tweet["tweet_id"].'"/>'	
                                      :'')).'
                                    </div>
                         			<div>
                         				<div class="t-h-c-name">
                         					<span><a href="'.BASE_URL.$tweet['username'].'">'.$tweet['username'].'</a></span>
                         					<span>@'.$tweet['username'].'</span>
                         					<span>'.$homepage->timeAgo($tweet['posted_on']).'</span>
                         				</div>
                         				<div class="retweet-t-s-b-inner-right-text">		
                         					'.$homepage->getTweetLink($tweet['status']).'
                         				</div>
                         			</div>
                         		</div>
                         	</div>
                         </div> 
                         </div> ':'

                    	<div class="t-show-popup" data-tweet="'.$tweet["tweet_id"].'">
                    		<div class="t-show-head">
                                <div class="t-show-img">
                                   '.((isset($user_id) == $tweet['user_id']  && empty($tweet['profile_image']) == 1)?
	 	                           '<img src="'.BASE_URL.NO_PROFILE_IMAGE_URL.'" />':'<img src="'.BASE_URL.$tweet["profile_image"].'"/>').'
                    			</div>
                    			<div class="t-s-head-content">
                    				<div class="t-h-c-name">
                    					<span><a href="'.BASE_URL.$tweet["username"].'">'.$tweet["screenname"].'</a></span>
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

                                 </div>').'
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
	             }
		?>
		</div>
	</div>

				<?php endif; ?>
				<div class="popupTweet"></div>

	</div><!--in full wrap end-->
</div><!-- in wrappper ends-->

</div><!-- ends wrapper -->
    <script src="<?php echo BASE_URL; ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/popper.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/search.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/hashtag.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/likes.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/retweet.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/popuptweet.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/comment.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/deletecomment.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/popupTweetForm.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/fetch_home.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/follow.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/message.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/postmessage.js"></script>

<?php echo $db->closeDb(); ?>
</body>
</html>


