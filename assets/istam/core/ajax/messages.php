<?php 
session_start();
include('../init.php');
$users->preventUsersAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

if (isset($_POST['deleteMessage']) && !empty($_POST['deleteMessage'])) {
    $user_id= $_SESSION['user_id'];
	$message_id= $users->test_input($_POST['deleteMessage']);
	$message->deleteMsg($message_id,$user_id);
}

if (isset($_POST['sendMessage']) && !empty($_POST['sendMessage'])) {
    $user_id= $_SESSION['user_id'];
	$message= $users->test_input($_POST['sendMessage']);
	$get_id=$_POST['get_idd'];
	if (!empty($message)) {
		# code...
		$homepage->creates('message',array('message_to' => $get_id,'message_from' => $user_id,'message' => $message,'message_on' => date('Y-m-d H:i:s')));
	}
}


if (isset($_POST['showChatMessage']) && !empty($_POST['showChatMessage'])) {
    $user_id= $_SESSION['user_id'];
    $message_from= $_POST['showChatMessage'];
    $message->getMessage($message_from,$user_id);
}

if (isset($_POST['showMessage']) && !empty($_POST['showMessage'])) {
    $user_id= $_SESSION['user_id'];
    // $tweet_id= $_POST['showMessage'];
	$Msg= $message->recentMessage($user_id); 
	$notification->messagesView($user_id);
    ?>

    <div class="popup-message-wrap">
        <input id="popup-message-tweet" type="checkbox" checked="unchecked"/>
        <div class="wrap2">
        <div class="message-send">
        	<div class="message-header">
        		<div class="message-h-left">
        			<label for="mass"><i class="fa fa-angle-left" aria-hidden="true"></i></label>
        		</div>
        		<div class="message-h-cen">
        			<h4>New message</h4>
        		</div>
        		<div class="message-h-right">
        			<label for="popup-message-tweet" ><i class="fa fa-times" aria-hidden="true"></i></label>
        		</div>
        	</div>
        	<div class="message-input">
        		<h4>Send message to:</h4>
        	  	<input type="text" placeholder="Search people" class="search-user"/>
        		<ul class="search-result down">
        				
        		</ul>
        	</div>
        	<div class="message-body">
        		<h4>Recent</h4>
        		<div class="message-recent">
                <?php foreach ($Msg as $Message ) {?>

        			<!--Direct Messages-->
        			<div class="people-message" data-user="<?php echo $Message['user_id'];?>">
        				<div class="people-inner">
        					<div class="people-img">
							<?php if (!empty($Message['profile_image'])) { ?>
        						     <img src="<?php echo BASE_URL.$Message['profile_image'];?>"/>
							<?php }else {?>
        						     <img src="<?php echo BASE_URL.NO_PROFILE_IMAGE_URL ;?>"/>
							<?php } ?>
        					</div>
        					<div class="name-right2">
        						<span><a href="#"><?php echo $Message['screenname'];?></a></span><span>@<?php echo $Message['username'];?></span>
        					</div>
        					
        					<span> 
        						<?php echo $users->timeAgo($Message['message_on']);?>
        					</span>
        				</div>
        			</div>
        			<!--Direct Messages-->

               <?php  }?>

        		</div>
        	</div>
        	<!--message FOOTER-->
        	<div class="message-footer">
        		<div class="ms-fo-right">
        			<label>Next</label>
        		</div>
        	</div><!-- message FOOTER END-->
        </div><!-- MESSGAE send ENDS-->
         
         
        	<input id="mass" type="checkbox" checked="unchecked" />
        	<div class="back">
        		<div class="back-header">
        			<div class="back-left">
        				Direct message
        			</div>
        			<div class="back-right">
        				<label for="mass"  class="new-message-btn">New messages</label>
        				<label for="popup-message-tweet"><i class="fa fa-times" aria-hidden="true"></i></label>
        			</div>
        		</div>
        		<div class="back-inner">
        			<div class="back-body">
                <?php foreach ( $Msg as $Message ) { 
                    ?>   

        			<!--Direct Messages-->
        				<div class="people-message" data-user="<?php echo $Message['user_id'];?>">
        					<div class="people-inner">
        						<div class="people-img">
									<?php if (!empty($Message['profile_image'])) { ?>
        						     <img src="<?php echo BASE_URL.$Message['profile_image'];?>"/>
							        <?php }else {?>
        					        	     <img src="<?php echo BASE_URL.NO_PROFILE_IMAGE_URL ;?>"/>
							        <?php } ?>
        						</div>
        						<div class="name-right2">
        							<span><a href="#"><?php echo $Message['screenname'];?></a></span><span>@<?php echo $Message['username'];?></span>
        						</div>
        						<div class="msg-box">
        						   <?php echo $Message['message'];?>
        						</div>
        
        						<span>
        						    <?php echo $users->timeAgo($Message['message_on']);?>
        						</span>
        					</div>
        				</div>
        				<!--Direct Messages-->
               <?php  }?>

        			</div>
        		</div>
        		<div class="back-footer">
        
        		</div>
        	</div>
        </div>
        </div>
        <!-- POPUP MESSAGES END HERE -->
<?php }


if (isset($_POST['showChatPopup']) && !empty($_POST['showChatPopup'])) {
    $user_id= $_SESSION['user_id'];
    $message_from= $_POST['showChatPopup'];
    $Msg= $message->recentMessage($user_id); 
    $user= $users->userData($message_from);
    ?>
    
    <!-- MESSAGE CHAT START -->
    <div class="popup-message-body-wrap">
    <input id="popup-message-tweet" type="checkbox" checked="unchecked"/>
    <input id="message-body" type="checkbox" checked="unchecked"/>
    <div class="wrap3">
    <div class="message-send2">
    	<div class="message-header2">
    		<div class="message-h-left">
    			<label class="back-messages" for="mass"><i class="fa fa-angle-left" aria-hidden="true"></i></label>
    		</div>
    		<div class="message-h-cen">
    			<div class="message-head-img">
				<?php if (!empty($user['profile_image'])) { ?>
    			     <img src="<?php echo BASE_URL.$user['profile_image'];?>"/><h4>Messages</h4>
				<?php }else {?>
    			     <img src="<?php echo BASE_URL.NO_PROFILE_IMAGE_URL ;?>"/><h4>Messages</h4>
				<?php } ?>
    			</div>
    		</div>
    		<div class="message-h-right">
    		  <label class="close-msgPopup" for="message-body" ><i class="fa fa-times" aria-hidden="true"></i></label> 
    		</div>
    		<div class="message-del">
    			<div class="message-del-inner">
    				<h4>Are you sure you want to delete this message? </h4>
    				<div class="message-del-box">
    					<span>
    						<button class="cancel" value="Cancel">Cancel</button>
    					</span>
    					<span>	
    						<button class="delete" value="Delete">Delete</button>
    					</span>
    				</div>
    			</div>
    		</div>
    	</div>
    	<div class="main-msg-wrap">
          <div id="chat" class="main-msg-inner">
         
     	  </div>
    	</div>
    	<div class="main-msg-footer">
    		<div class="main-msg-footer-inner">
    			<ul>
    				<li><textarea id="msg" name="msg" placeholder="Write some thing!"></textarea></li>
    				<li><input id="msg-upload" type="file" value="upload"/><label for="msg-upload"><i class="fa fa-camera" aria-hidden="true"></i></label></li>
    				<li><input id="send" data-user="<?php echo  $message_from ;?>" type="submit" value="Send"/></li>
    			</ul>
    		</div>
    	</div>
     </div> <!--MASSGAE send ENDS-->
    </div> <!--wrap 3 end-->
    </div><!--POP UP message WRAP END-->
    
    <!-- message Chat popup end -->
<?php }
  ?>