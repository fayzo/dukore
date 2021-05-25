<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('Location: ../index.php');
}

$screenName=$email=$password="";

if (isset($_POST['signup'])) {
    $screenName=$_POST['screenName'];
    $email=$_POST['email'];
    $password=$_POST['password'];

    if (empty($screenName) || empty($email) || empty($password)) {
        $errors="fields required";
    }else {
        $screenName= $users->escape_string($users->test_input($screenName));
        $email= $users->escape_string($users->test_input($email));
        $password= $users->escape_string($users->test_input($password));

        if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $errors="invalid email";
        }elseif (strlen($screenName) > 20) {
            $errors="Name must be between 6-20 character";
        }elseif (strlen($password) < 5) {
            $errors="password is too short";
        }else {
            if ($users->checkEmail($email) == true) {
                 $errors="email already used";
            }else {
				$users->register($screenName,$email,$password);
				header('Location: '.BASE_URL.'home');

            }
        }
    }
}
?>
<form method="post">
<div class="signup-div"> 
	<h3>Sign up </h3>
	<ul>
		<li>
		    <input type="text" name="screenName" value="<?php echo $screenName;?>" placeholder="Full Name"/>
		</li>
		<li>
		    <input type="email" name="email" value="<?php echo $email;?>" placeholder="Email"/>
		</li>
		<li>
			<input type="password" name="password" value="<?php echo $password;?>" placeholder="Password"/>
		</li>
		<li>
			<input type="submit" name="signup" Value="Signup for Twitter">
		</li>
	</ul>
	<?php if (isset($errors)) {
        echo '<li class="error-li">
                 <div class="span-fp-error">'.$errors.'</div>
              </li> ';
    } ?>
</div>
</form>