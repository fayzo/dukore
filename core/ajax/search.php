<?php 
session_start();
include('../init.php');
$users->preventUsersAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

if (isset($_POST['search']) && !empty($_POST['search'])) {
    # code...
    $search= $users->test_input($_POST['search']);
    $result= $users->search($search);

     if (is_array($result) || is_object($result)){

         echo '<div class="nav-right-down-wrap">
                <ul> ';
                //  echo var_dump($result);
    
    foreach ($result as $user) {
        # code...
        ?>
                 <li>
  	            	<div class="nav-right-down-inner">
	            		<div class="nav-right-down-left">
	            			<a href="<?php echo BASE_URL ;?>profile.php?username=<?php echo $user["username"];?>"> 
                            <?php if (empty($user['profile_image']) == 1) {
		                    	# code...
		                          echo '<img src="'.BASE_URL.'assets/images/defaultprofileimage.png" />';
		                    }elseif (!empty($user['profile_image']) == $user['profile_image']) {
		                    	# code...
		                          echo '<img src="'.BASE_URL.$user['profile_image'].'"/>';
		                    }
		                    ?>
                            </a>
	            		</div>
	            		<div class="nav-right-down-right">
	            			<div class="nav-right-down-right-headline">
	            				<a href="<?php echo BASE_URL ;?>profile.php?username=<?php echo $user["username"] ;?>"><?php echo $user["screenname"] ;?></a><span>@<?php echo $user["username"]; ?></span>
	            			</div>
	            			<div class="nav-right-down-right-body">
	            			 
	            		    </div>
	            		</div>
	            	</div> 
	             </li> 
     <?php } ?>
           </ul>
         </div> 
<?php  }
}
?>