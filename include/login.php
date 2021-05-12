<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('Location: ../index.php');
}

$email=$password="";

if (isset($_POST['login'])) {
    # code...
 if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email= $users->test_input($_POST['email']);
        $password= $users->test_input($_POST['password']);

        if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $error['email']= 'invalid format';
        }elseif (!preg_match("/^[a-zA-Z ]*$/", $password)) {
            $error['password'] = "Only letters and white space allowed";
        }else {
            if ($users->login($email,$password) == false) {
                if ($email == $_SESSION['email']) {
                    $error['email']= 'email correct ';
                }elseif ($email != $_SESSION['email']){
                    $error['email']= 'invalid email';
                }
                $error['fields']= 'invalid passord';
            }
        }

    }else{
       $error['fields']= "Please insert your email and password ";
    }
}
?>
<div class="login-div">
    <form method="post"> 
    	<ul>
    		<li>
    		  <input type="text" name="email" value="<?php echo $email;?>" placeholder="Please enter your Email here"/>
    		</li>
            <?php if (isset($error['email']))
              {
                 echo ' <li class="error-li">
    	                <div class="span-fp-error">'.$error["email"].'</div>
    	               </li> ';
             }
             ?>
    		<li>
    		  <input type="password" name="password" value="<?php echo $password;?>" placeholder="password"/>
              <input type="submit" name="login" value="Log in"/>
    		</li>
            
    		<li>
    		  <input type="checkbox" Value="Remember me">Remember me
    		</li>
           <?php
           if (isset($error['fields']))
            {
               echo ' <li class="error-li">
    	               <div class="span-fp-error">'.$error["fields"].'</div>
    	              </li> ';
           }
           ?>
    	</ul>
    	
    </form>
</div>