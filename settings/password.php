<?php 
session_start();
include('../core/init.php');
if ($users->loggedin() == false) {
	header('location: '.BASE_URL.'index.php');
}

$user_id=$_SESSION['user_id'];
$user=$users->userData($user_id);
$notific= $notification->getNotificationCount($user_id);
$notification->notificationsView($user_id);

$currentPwd=$newPassword=$verifyPassword="";
if (isset($_POST['submit'])) {
	# code...
	$currentPwd= $users->test_input($_POST['currentPwd']);
	$newPassword= $users->test_input($_POST['newPassword']);
	$verifyPassword= $users->test_input($_POST['rePassword']);
	$error= array();

	if (!empty($currentPwd) && !empty($newPassword) && !empty($verifyPassword)) {
		# code...
		if ($user['password'] == $currentPwd && $users->checkPassword($currentPwd) == $currentPwd) {
			# code...
			$error['current password']= "your current passsword is correct";
			
		    if (strlen($currentPwd) < 6 ) {
		    	# code...
				$error['current password']= "password is too short";
				 if (!preg_match("/^[a-zA-Z ]*$/", $currentPwd)) {
		        	# code...
                   $error['current password']= "Only letters and white space allowed";
		          }
			}elseif (strlen($newPassword) < 6 ) {
		            # code...
					$error['new password']= "password is too short";
					
			         if (!preg_match("/^[a-zA-Z ]*$/",$newPassword)) {
		            	# code...
				    	$error['new password']= "Only letters and white space allowed";
				     }
			}elseif (strlen($verifyPassword) < 6 ) {
		    	     # code...
					 $error['verify password']= "password is too short";
					 
			          if (!preg_match("/^[a-zA-Z ]*$/",$verifyPassword)) {
		    	         # code...
				    	 $error['verify password']= "Only letters and white space allowed";
				      }
			}elseif ($newPassword !=  $verifyPassword) {
		    	# code...
                $error['verify password']= "password don't match";
			}else {
				# code...
			    $users->update('users', array('password' => $verifyPassword), $user_id);
			    header('Location:'.BASE_URL.'settings/password.php');
			}

		}else{
			# code...
			$error['current password']= "your current passsword is not correct";
		}
		
	}else {
		$error['fields']="All fields required";
	}
}


?>
<html>
	<head>
		<title>Password settings page</title>
		<meta charset="UTF-8" />
        <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style-complete.css"/>
        <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/font/css/font-awesome.min.css"/>
		<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<link rel="stylesheet" href="assets/css/style-complete.css"/> -->
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
				<li><input type="text" placeholder="Search" class="search"/><i class="fa fa-search" aria-hidden="true"></i></li>
				<div class="nav-right-down-wrap">
					<ul class="search-result">
					
					</ul>
				</div>
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
							<li><a href="<?php echo BASE_URL;?><?php echo $user['username'];?>"><?php echo $user['username'];?></a></li>
							<li><a href="<?php echo BASE_URL;?>settings.account">Settings</a></li>
							<li><a href="<?php echo BASE_URL;?>include.logout">Log out</a></li>
						</ul> 
					</div>
				</div>
				</li>
				<li><label for="pop-up-tweet">Tweet</label></li>

			</ul>
		</div>
		<!-- nav right ends-->
 
	</div>
	<!-- nav ends -->

</div><!-- nav container ends -->
</div><!-- header wrapper end -->
		
	<div class="container-wrap">

		<div class="lefter">
			<div class="inner-lefter">

				<div class="acc-info-wrap">
					<div class="acc-info-bg">
						<!-- PROFILE-COVER -->
						<?php if (isset($user_id) == $user['user_id']  && empty($user['profile_cover']) == 1) {
		            	# code...
				    	   echo '<img src="'.BASE_URL.NO_COVER_IMAGE_URL.'" />';
				        	  
		                }elseif (isset($user_id) == $user['user_id']  && !empty($user['profile_cover']) == $user['profile_cover']) {
		                	# code...
				        	   echo '<img src="'.BASE_URL.$user["profile_cover"].'"/>';
		                }
		                ?>
					</div>
					<div class="acc-info-img">
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
					<div class="acc-info-name">
						<h3><?php echo $user['screenname'];?></h3>
						<span><a href="<?php echo BASE_URL;?><?php echo $user['username'];?>"><?php echo $user['username'];?></a></span>
					</div>
				</div><!--Acc info wrap end-->

				<div class="option-box">
					<ul> 
						<li>
							<a href="<?php echo BASE_URL;?>settings.account" class="bold">
							<div>
								Account
								<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>
							</a>
						</li>
						<li>
							<a href="<?php echo BASE_URL;?>settings.password">
							<div>
								Password
								<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>
							</a>
						</li>
					</ul>
				</div>

			</div>
		</div><!--LEFTER ENDS-->
	
	<div class="righter">
		<div class="inner-righter">
			<div class="acc">
				<div class="acc-heading">
					<h2>Password</h2>
					<h3>Change your password or recover your current one.</h3>
				</div>
				<form method="POST">
				<div class="acc-content">
					<div class="acc-wrap">
						<div class="acc-left">
							Current password
						</div>
						<div class="acc-right">
							<input type="password" name="currentPwd" value="<?php echo $currentPwd;?>"/>
							<span>
								<?php
						           if (isset($error['current password'])) {
						          	 echo $error['current password'];
							      }
							    ?>
							</span>
						</div>
					</div>

					<div class="acc-wrap">
						<div class="acc-left">
							New password
						</div>
						<div class="acc-right">
							<input type="password" name="newPassword" value="<?php echo $newPassword;?>" />
							<span>
								<?php
						           if (isset($error['new password'])) {
						          	 echo $error['new password'];
							      }
							    ?>
							</span>
						</div>
					</div>

					<div class="acc-wrap">
						<div class="acc-left">
							Verify password
						</div>
						<div class="acc-right">
							<input type="password" name="rePassword" value="<?php echo $verifyPassword;?>" />
							<span>
								<?php
						           if (isset($error['verify password'])) {
						          	 echo $error['verify password'];
							      }
							    ?>
							</span>
						</div>
					</div>
					<div class="acc-wrap">
						<div class="acc-left">
						</div>
						<div class="acc-right">
						    <span>
			                	<button class="f-btn" type="button" onclick="window.location.href='<?php echo BASE_URL.'profile.php?username='.$user['username'];?>'" value="Cancel">Cancel</button>
			                </span>
							<input type="Submit" name="submit" value="Save changes"/>
						</div>
						<div class="settings-error">
							<?php
						       if (isset($error['fields'])) {
						      	 echo $error['fields'];
							  }
							?>
 						</div>	
					</div>
				 </form>
				</div>
			</div>
			<div class="content-setting">
				<div class="content-heading">
					
				</div>
				<div class="content-content">
					<div class="content-left">
						
					</div>
					<div class="content-right">
						
					</div>
				</div>
			</div>
		</div>	
	</div>
	<!--RIGHTER ENDS-->
	
	<div class="popupTweet"></div>

</div>
<!--CONTAINER_WRAP ENDS-->
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
    <script src="<?php echo BASE_URL;?>assets/js/follow.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/message.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/postmessage.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/notification.js"></script>
</body>
</html>
