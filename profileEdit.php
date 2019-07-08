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

if (isset($_POST['screenName'])) {
    if (!empty($_POST['screenName'])) {
        $screenname= $users->test_input($_POST['screenName']);
        $bio= $users->test_input($_POST['bio']);
        $country= $users->test_input($_POST['country']);
        $website= $users->test_input($_POST['website']);

        if (strlen($screenname) > 20) {
            $error="Name must be between 2-20 characters";
        }elseif (strlen($bio) > 120) {
            $error="Description is too long";
        }else{
            $users->update('users',array('screenname' => $screenname,'bio' => $bio,'country' => $country,'website' => $website),$user_id);
        }

    }else {
        $error= "Name field can't blink";
    }
}

if (isset($_FILES['profileImage'])) {
     if (!empty($_FILES['profileImage']['name'])) {
         $fileRoot= $users->uploadImageProfile($_FILES['profileImage']);
         $users->update('users',array('profile_image' => $fileRoot),$user_id);
     }
}

if (isset($_FILES['profileCover'])) {
     if (!empty($_FILES['profileCover']['name'])) {
         $fileRoot=$users->uploadImageCover($_FILES['profileCover']);
         $users->update('users',array('profile_cover' => $fileRoot),$user_id);
     }
}
?>
<!doctype html>
<html>
<head>
	<title><?php echo $user['screenname'].' @'.$user['username'].' Edit page' ;?></title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style-complete.css"/>
    <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/font/css/font-awesome.min.css"/>
     <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>   -->
	<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>  	   -->
</head>
<!--Helvetica Neue-->
<body>
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
		</div>
		<!-- nav left ends-->
		<div class="nav-right">
			<ul>
				<li><input type="text" placeholder="Search" class="search"/><i class="fa fa-search" aria-hidden="true"></i>
				<div class="search-result">
					 			
				</div></li>
				<?php if (isset($user_id) == $user['user_id']  && empty($user['profile_image']) == 1) {
	        		# code...
					  echo '<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="'.NO_PROFILE_IMAGE_URL.'"/></label>';
	        	}else {
	        		# code...
					  echo '<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="'.$user["profile_image"].'"/></label>';
	        	}?>
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
			</ul>
		</div>
		<!-- nav right ends-->
	</div>
	<!-- nav ends -->
</div>
<!-- nav container ends -->
</div>
<!-- header wrapper end -->

<!--Profile cover-->
<div class="profile-cover-wrap"> 
<div class="profile-cover-inner">
	<div class="profile-cover-img">
	   <!-- PROFILE-COVER -->
	   	<?php if (isset($user_id) == $user['user_id']  && empty($user['profile_cover']) == 1) {
			# code...
		      echo "<img src='".BASE_URL.NO_COVER_IMAGE_URL."' />";
		}elseif (isset($user_id) == $user['user_id']  && !empty($user['profile_cover']) == $user['profile_cover']) {
			# code...
		      echo "<img src='".BASE_URL."$user[profile_cover]'/>";
		}
		?>
		<div class="img-upload-button-wrap">
			<div class="img-upload-button1">
				<label for="cover-upload-btn">
					<i class="fa fa-camera" aria-hidden="true"></i>
				</label>
				<span class="span-text1">
					Change your profile photo
				</span>
				<input id="cover-upload-btn" type="checkbox"/>
				<div class="img-upload-menu1">
					<span class="img-upload-arrow"></span>
					<form method="post" enctype="multipart/form-data">
						<ul>
							<li>
								<label for="file-up">
									Upload photo
								</label>
								<input type="file" name="profileCover" onchange="this.form.submit();" id="file-up" />
							</li>
								<li>
								<label for="cover-upload-btn">
									Cancel
								</label>
							</li>
						</ul>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="profile-nav">
	<div class="profile-navigation">
		<ul>
			<li>
				<a href="#">
					<div class="n-head">
						TWEETS
					</div>
					<div class="n-bottom">
    	             	<?php echo $homepage->countsTweet($user_id) ;?>
					</div>
				</a>
			</li>
			<li>
				<a href="<?php echo BASE_URL.$user['username'].'.following' ;?>">
					<div class="n-head">
						FOLLOWINGS
					</div>
					<div class="n-bottom">
						<?php echo $user['following'];?>
					</div>
				</a>
			</li>
			<li>
				<a href="<?php echo BASE_URL.$user['username'].'.followers' ;?>">
					<div class="n-head">
						FOLLOWERS
					</div>
					<div class="n-bottom">
						<?php echo $user['followers'];?>
					</div>
				</a>
			</li>
			<li>
				<a href="#">
					<div class="n-head">
						LIKES
					</div>
					<div class="n-bottom">
			     	     <?php echo $homepage->countsLike($user_id) ;?>
					</div>
				</a>
			</li>
			
		</ul>
		<div class="edit-button">
			<span>
				<button class="f-btn" type="button" onclick="window.location.href='<?php echo BASE_URL.$user['username'];?>'" value="Cancel">Cancel</button>
			</span>
			<span>
				<input type="submit" id="save" value="Save Changes">
			</span>
		 
		</div>
	</div>
</div>
</div><!--Profile Cover End-->

<div class="in-wrapper">
<div class="in-full-wrap">
  <div class="in-left">
	<div class="in-left-wrap">
		<!--PROFILE INFO WRAPPER END-->
<div class="profile-info-wrap">
	<div class="profile-info-inner">
		<div class="profile-img">
			<!-- PROFILE-IMAGE -->
			<?php if (isset($user_id) == $user['user_id']  && empty($user['profile_image']) == 1) {
		    	# code...
		          echo "<img src='".BASE_URL.NO_PROFILE_IMAGE_URL."' />";
		    }elseif (isset($user_id) == $user['user_id']  && !empty($user['profile_image']) == $user['profile_image']) {
		    	# code...
		          echo "<img src='".BASE_URL."$user[profile_image]'/>";
		    }
		    ?>
 			<div class="img-upload-button-wrap1">
			 <div class="img-upload-button">
				<label for="img-upload-btn">
					<i class="fa fa-camera" aria-hidden="true"></i>
				</label>
				<span class="span-text">
					Change your profile photo
				</span>
				<input id="img-upload-btn" type="checkbox"/>
				<div class="img-upload-menu">
				 <span class="img-upload-arrow"></span>
					<form method="post" enctype="multipart/form-data">
						<ul>
							<li>
								<label for="profileImage">
									Upload photo
								</label>
								<input id="profileImage" type="file"  onchange="this.form.submit();" name="profileImage"/>
								
							</li>
							<li><a href="#">Remove</a></li>
							<li>
								<label for="img-upload-btn">
									Cancel
								</label>
							</li>
						</ul>
					</form>
				</div>
			  </div>
			  <!-- img upload end-->
			</div>
		</div>

			    <form id="editForm" method="post" enctype="multipart/Form-data">	
				    <div class="profile-name-wrap">
                    <?php if (isset($imageError)) {
                        echo '
				    	<ul>
	 			    		 <li class="error-li">
				    		 	 <div class="span-pe-error">'.$imageError.'</div>
				    		 </li>
				    	 </ul> ';
                     }?>

				    	<div class="profile-name">
				    		<input type="text" name="screenName" value="<?php echo $user['screenname'];?>"/>
				    	</div>
				    	<div class="profile-tname">
				    		@<?php echo $user['username'];?>
				    	</div>
				    </div>

				    <div class="profile-bio-wrap">
				    	<div class="profile-bio-inner">
				    		<textarea class="status" name="bio"><?php echo $user['bio'];?></textarea>
				    		<div class="hash-box">
				    	 		<ul>
				    	 		</ul>
				    	 	</div>
				    	</div>
				    </div>

					<div class="profile-extra-info">
					    <div class="profile-extra-inner">
					    	<ul>
					    		<li>
					    			<div class="profile-ex-location">
					    				<input id="cn" type="text" name="country" placeholder="Country" value="<?php echo $user['country'];?>" />
					    			</div>
					    		</li>
					    		<li>
					    			<div class="profile-ex-location">
					    				<input type="text" name="website" placeholder="Website" value="<?php echo $user['website'];?>"/>
					    			</div>
					    		</li>
					    	</ul>						
					    </div>
				    </div>
                     <?php if (isset($Error)) {
                        echo '
				    	<ul>
	 			    		 <li class="error-li">
				    		 	 <div class="span-pe-error">'.$Error.'</div>
				    		 </li>
				    	 </ul> ';
                     }?>

				</form>
				<div class="profile-extra-footer">
					<div class="profile-extra-footer-head">
						<div class="profile-extra-info">
							<ul>
								<li>
									<div class="profile-ex-location-i">
										<i class="fa fa-camera" aria-hidden="true"></i>
									</div>
									<div class="profile-ex-location">
										<a href="#">0 Photos and videos </a>
									</div>
								</li>
							</ul>
						</div>
					</div>
					<div class="profile-extra-footer-body">
						<ul>
						  <!-- <li><img src="#"></li> -->
						</ul>
					</div>
				</div>
			</div>
			<!--PROFILE INFO INNER END-->
		</div>
		<!--PROFILE INFO WRAPPER END-->
	</div>
	<!-- in left wrap-->
</div>
<!-- in left end-->

<div class="in-center">
	<div class="in-center-wrap">	
		<!-- HERE WILL BE TWEETS -->

	<?php 
	 $tweets= $homepage->getUserTweet($user['user_id']);
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
                                                <li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>	
                                                <li>'.(($tweet['tweet_id'] == $Retweet["retweet_id"] || $user_id == $Retweet['retweet_by'])? '<button class="retweeted" data-tweet="'.$tweet["tweet_id"].'"  data-user="'.$tweet["tweetBy"].'" ><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetcounter" >'.$Retweet["retweet_counts"].'</span></button>':'<button class="retweet" data-tweet="'.$tweet["tweet_id"].'"  data-user="'.$tweet["tweetBy"].'" ><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetcounter" >'.(($Retweet["retweet_counts"] > 0)? $Retweet["retweet_counts"] :'' ).'</span></button>').'</li>
                                                <li>'.(($tweet_likes["like_on"] == $tweet["tweet_id"])? '<button class="unlike-btn" data-tweet="'.$tweet["tweet_id"].'"  data-user="'.$tweet["tweetBy"].'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likescounter" >'.$tweet["likes_counts"].'</span></button> ' : '<button class="like-btn" data-tweet="'.$tweet["tweet_id"].'"  data-user="'.$tweet["tweetBy"].'"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likescounter" >'.(($tweet["likes_counts"] > 0)? $tweet["likes_counts"]:'' ).'</span></button> ').'</li>
                                                '.(($tweet["tweetBy"] == $user_id)?'
											    <li>
                        					       <a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
											       <ul> 
                        					         <li><label class="deleteTweet" data-tweet="'.$tweet["tweet_id"].'" data-user="'.$tweet["tweetBy"].'" >Delete Tweet</label></li>
                        					       </ul>
											    </li>
											    ':'').'
                                			</ul>
                                		</div>
                                	</div>
                                 </div>
                                </div>
                              </div> ';
	 }?>
	</div>
	<!-- in left wrap-->
   <div class="popupTweet"></div>

</div>
<!-- in center end -->

<div class="in-right">
	<div class="in-right-wrap">
		<!--Who To Follow-->
	      <!--WHO_TO_FOLLOW HERE-->
			<?php $follow->whoTofollow($user_id); ?>
        <!--Who To Follow-->
			
		<!--==TRENDS==-->
 	 	   <!-- HERE -->
	   <?php $trending->trends() ; ?>
	 	<!--==TRENDS==-->
	</div>
	<!-- in left wrap-->
</div>
<!-- in right end -->

   </div>
   <!--in full wrap end-->
 
  </div>
  <!-- in wrappper ends-->

</div>
<!-- ends wrapper -->
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
    <script src="<?php echo BASE_URL;?>assets/js/message.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/postmessage.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/notification.js"></script>

    <script type="text/javascript">
    $('#save').on('click',function () {
        $('#editForm').submit();
    })
    </script>
	
<?php echo $db->closeDb(); ?>

</body>
</html>