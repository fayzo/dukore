<?php 
session_start();
include('../init.php');
$users->preventUsersAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

if (isset($_POST['search']) && !empty($_POST['search'])) {
    $user_id= $_SESSION['user_id'];
    $search= $users->test_input($_POST['search']);
    $result= $users->search($search);
    echo '<h4>People</h4>
          <div class="message-recent"> 
          ';
     foreach ($result as $user) {
         if ($user['user_id'] != $user_id) {
             # code...
             echo '<div class="people-message" data-user="'.$user['user_id'].'">
                    	<div class="people-inner">
                    		<div class="people-img">
                    			 '.((!empty($user['profile_image']))?'
                                    <a href="#"><img src="'.BASE_URL.$user['profile_image'].'"/></a>
                                    ':'
                                    <a href="#"><img src="'.BASE_URL.NO_PROFILE_IMAGE_URL.'"/></a>
                                ').'
                    		</div>
                    		<div class="name-right">
                    			<span><a>'.$user['screenname'].'</a></span><span>@'.$user['username'].'</span>
                    		</div>
                    	</div>
                     </div> ';
         }
      }
      echo '</div>';
}
?>