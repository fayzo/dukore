<?php
session_start();
include('core/init.php');

if ($users->loggedin() == false) {
	header('location: '.BASE_URL.'index.php');
}

$user_id=$_SESSION['user_id'];
$user=$users->userData($user_id);
$notific= $notification->getNotificationCount($user_id);

if (isset($_POST['tweet']) && !empty($_POST['tweet'])) {
	# code...
	$status= $homepage->test_input($_POST['status']);
	$files= $_FILES['file'];

	if (!empty($status) || !empty($files['name'][0])) {
		if (!empty($files)) {
			# code...
			$tweetimages = $homepage->uploadImageProfiles($files);
		}

		if (strlen($status) > 140) {
			$error= "The text is too long";
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
		<title><?php echo $user['screenname'].'@'.$user['username']; ?> look others Tweet</title>
		  <meta charset="UTF-8" />
		   <meta http-equiv="X-UA-Compatible" content="IE=edge">
           <meta name="viewport" content="width=device-width, initial-scale=1">
	      <link rel="stylesheet" href="<?php echo BASE_URL ;?>assets/css/font/css/font-awesome.min.css"/>
          <link rel="stylesheet" type="text/css" media="screen" href="<?php echo BASE_URL ;?>assets/css/styles.css" />
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
							<li><button type="button" onclick='white()' class="btn btn-light btn-sm mr-2 ">white</button></li>
							<li><button type="button" onclick='black()' class="btn btn-dark btn-sm mr-2">black</button></li>
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
				<div class="tweet-wrap" style="margin-bottom:10px;">
					<div class="tweet-inner">
						 <div class="tweet-h-left">
						 	<div class="tweet-h-img">
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
						 </div>
						 <div class="tweet-body">
						 <form method="post" enctype="multipart/form-data">
							<textarea class="status" name="status" placeholder="Type Something here!" rows="4" cols="50"></textarea>
 						 	<div class="hash-box">
						 		<ul>
  						 		</ul>
						 	</div>
 						 </div>
						 <div class="tweet-footer">
						 	<div class="t-fo-left">
						 		<ul>
						 			<input type="file" name="file" id="file"/>
						 			<li><label for="file"><i class="fa fa-camera" aria-hidden="true"></i></label>
						 			<span class="tweet-error">
									 <?php 
									 if (isset($error)) {
										 # code...
										 echo $error;
									 }elseif (isset($imageError)) {
										 # code...
										  echo $imageError;
									 }
									 ?></span>
						 			</li>
						 		</ul>
						 	</div>
						 	<div class="t-fo-right">
						 		<span id="count">140</span>
						 		<input type="submit" name="tweet" value="tweet"/>
				 		</form>
						 	</div>
						 </div>
					</div>
				</div><!--TWEET WRAP END-->

				<!--Tweet SHOW WRAPPER-->
				 <div class="tweets">
 				  	<!--TWEETS HERE-->
					   <?php echo $homepage->tweet($user_id,5); ?>
 				 </div>
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
    <script src="<?php echo BASE_URL;?>assets/js/theme.js"></script>

<?php echo $db->closeDb(); ?>
</body>
</html>