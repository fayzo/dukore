<?php 

class  User
{
    protected $database;
    static protected $databases;

    static public function getdatabse($db)
    {
       return self::$databases= $db;
    }

    public function __construct($dbs)
    {
        $this->database=$dbs;
    }
    public function test_input($data)
    {
        $mysqli=$this->database;
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = $mysqli->real_escape_string($data);
        return $data;
    }

    public function escape_string($string)
    {
        $mysqli=$this->database;
        $escape_string= $mysqli->real_escape_string($string);
        return $escape_string;
    }

    public function preventUsersAccess($request,$currentfile,$currently)
    {
       if ($request == 'GET' && $currentfile == $currently) {
            header('Location: '.BASE_URL.'index.php');
        }
    }

    public function login($email,$password)
    {
        global $db;
        $mysqli=$db->getconnection();
        $query= $mysqli->query("SELECT user_id , email FROM users WHERE email='$email' AND password= '$password' ");
        $row= $query->fetch_array();
        $count=$query->num_rows;
        if ($count > 0) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['email'] = $row['email'];
            if (isset($_SESSION['user_id'])){
               header('Location: '.BASE_URL.'home');
                return true;
             }
        }else {
            $_SESSION['email'] = $row['email'];
            return false;
        }
    }

    public function update($table,$fields=array(),$user_id)
    {
        $columns="";
        $i= 1;
        foreach ($fields as $key => $value) {
            # code...
            $columns .= "{$key} = '{$value}'";
            if ($i++ < count($fields)) {
                # code...
                 $columns .= ',';
            }
        }
        global $db;
        $mysqli=$db->getconnection();
        $query= $mysqli->query("UPDATE $table SET {$columns} WHERE user_id='$user_id'");
        var_dump($query);
    }

     public function delete($table,$array)
    {
        $mysqli= $this->database;
        // $stmt = $mysqli->stmt_init();
        // $query= "SELECT * FROM tweety, users WHERE tweet_id = $tweet_id AND tweetBy =$user_id";
        $query= "DELETE FROM $table";
        $where= " WHERE"; 
        foreach ($array as $name => $value) {
            # code...
             $query .= "{$where} {$name} = {$value}";
             $where= " AND"; 
        }

        $mysqli->query($query);
        // var_dump( $mysqli->query($query));

    }

    public function userData($user_id)
    {
        global $db;
        $mysqli=$db->getconnection();
        $query= $mysqli->query("SELECT * FROM users WHERE user_id= '{$user_id}' ");
        $row= $query->fetch_array();
        return $row;
    }

      public function logout()
    {
        session_unset($_SESSION['user_id']);
        session_destroy();
        header ('Location: '.BASE_URL.'index.php');
    }

       public function loggedin()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        }else {
            return false;
        }
    }

    public function register($screenName,$email,$password)
    {
        global $db;
        $mysqli=$db->getconnection();
        // $query = $mysqli->query("INSERT INTO users (username, email, password) 
        // values ('$screenName','$email','$password') ");

        /* The argument may be one of four types :
            i - integer
            d - double
            s - string
            b - BLOB */
        $stmt = $mysqli->stmt_init();
        $query = "INSERT INTO users(username, email, password) values(?,?,?)";
        $stmt->prepare($query);
        $stmt->bind_param('sss', $screenName, $email ,md5($password));
        $stmt->execute();
        $user_id=$mysqli->insert_id;
        $_SESSION['user_id']= $user_id;
        $stmt->close();
    }

    public function search($search)
    {
        global $db;
        $mysqli=$db->getconnection();
        // $query = $mysqli->query("INSERT INTO users (username, email, password) 
        // values ('$screenName','$email','$password') ");

        /* The argument may be one of four types :
            i - integer
            d - double
            s - string
            b - BLOB */
        $stmt = $mysqli->stmt_init();
        $query = "SELECT user_id, username, email, screenname, profile_image FROM users Where username LIKE ? OR screenname LIKE ? ";
        $stmt->prepare($query);
        $param= '%'.$search.'%';
        $stmt->bind_param('ss', $param,$param);
        $stmt->execute();

        $stmt->bind_result($user_id, $username, $email, $screenname,$profile_image);
        $contacts = array();
        while ($stmt->fetch()) {
            $contacts[] = array(
            'user_id' => $user_id,
            'username' => $username,
            'email' => $email,
            'screenname' => $screenname,
            'profile_image' => $profile_image
           );
        }
        return $contacts; // Return the $contacts array
        $stmt->close();
    }

    public function usersNameId($username)
    {
        global $db;
        $mysqli=$db->getconnection();
        $query= $mysqli->query("SELECT user_id FROM users WHERE username= '$username'");
        $row= $query->fetch_array();
        return $row;

    }

    public function checkUsername($username)
    {
        global $db;
        $mysqli=$db->getconnection();
        $query= $mysqli->query("SELECT username FROM users WHERE username= '$username'");
        $count=$query->num_rows;
        if ($count > 0) {
            return true;
        }else {
            return false;
        }
        $row= $query->fetch_array();
        return $row;

    }

     public function checkEmail($email)
    {
        global $db;
        $mysqli=$db->getconnection();
        $query= $mysqli->query("SELECT email FROM users WHERE email= '$email' ");
        $count=$query->num_rows;
        if ($count > 0) {
            return true;
        }else {
            return false;
        }
        $row= $query->fetch_array();
        return $row;

    }

     public function checkPassword($password)
    {
        global $db;
        $mysqli=$db->getconnection();
        $query= $mysqli->query("SELECT password FROM users WHERE password= '$password' ");
        $count=$query->num_rows;
        if ($count > 0) {
            return true;
        }else {
            return false;
        }
        $row= $query->fetch_array();
        return $row;
    }

     public function uploadImageProfile($files)
    {
        global $db;
        $mysqli=$db->getconnection();
        $filename= basename($files['name']);
        $fileTmpName= $files['tmp_name'];
        $filesize= $files['size'];
        $error= $files['error'];

        $fileExt = explode('.', $filename);
        $fileActualExt = strtolower(end($fileExt));
        $allower_ext = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions

        if (in_array($fileActualExt,$allower_ext) == true) {
            # code...
             if ($error == 0) {
                 if ($filesize <= 100*1024) {
                     # code...
                     $filename= basename($files['name']);
                     $filenames = (strlen($filename) > 10)? 
                     strtolower(rand(100,1000).substr($filename,0,4).".".$fileActualExt):
                     strtolower(rand(100,1000).$filename);
                     $fileTmpName = $files['tmp_name'];
                    //  $file_dest= 'uploads/profile/'.$filenames;
                     $file_dest = $_SERVER['DOCUMENT_ROOT'].'tweet/'.'uploads/posts/'.$filenames;
                     if (move_uploaded_file($fileTmpName,$file_dest)) {
                         # code...
                         $user_id= $_SESSION['user_id'];
                         $uploadDir = "uploads/profile/";
                         $queryz=  $mysqli->query("SELECT profile_image FROM users WHERE user_id='{$user_id}'");
                         $rowz= $queryz->fetch_assoc();
                         $filez= $rowz['profile_image'] ;

                         if (file_exists($filez) == true ) { 
                                unlink($filez);
                                echo "<script>alert('file deleted')</script>";
                          }else{
                              echo "<script>alert('file was uploaded')</script>";
                          }
                        //   if (!unlink($filez)) {
                        //     echo "<script>alert('file was not deleted')</script>";
                        //     }else{ echo "<script>alert('file deleted')</script>";}
                        }
                        return substr($file_dest,22);

                 }else {
                      switch ($files['error']) {

                        case 2:
                             $GLOBALS['imageError']= $files['name'].' <span style = "color:red";>is too big</span>';
                            break;
                         case 4:
                             $GLOBALS['imageError']= $files['name'].' <span style = "color:red";>No file selected</span>';
                            break;
                        default:
                             $GLOBALS['imageError']= $files['name'].' <span style = "color:red";>sorry that type of file is not allowed</span>';
                            break;
                       }
                 }
             }

        }else {
                $GLOBALS['imageError']="the extension is not allowed";
        }
    }

     public function uploadImageCover($files)
    {
        global $db;
        $mysqli=$db->getconnection();
        $filename= basename($files['name']);
        $fileTmpName= $files['tmp_name'];
        $filesize= $files['size'];
        $error= $files['error'];

        $fileExt = explode('.', $filename);
        $fileActualExt = strtolower(end($fileExt));
        $allower_ext = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions

        if (in_array($fileActualExt,$allower_ext) == true) {
            # code...
             if ($error == 0) {
                 if ($filesize <= 100*1024) {
                     # code...
                     $filenames = (strlen($filename) > 10)? 
                     strtolower(rand(100,1000).substr($filename,0,4).".".$fileActualExt):
                     strtolower(rand(100,1000).$filename);
                     $fileTmpName = $files['tmp_name'];
                    //  $file_dest= 'uploads/profile/'.$filenames;
                     $file_dest = $_SERVER['DOCUMENT_ROOT'].'tweet/'.'uploads/posts/'.$filenames;
                     if (move_uploaded_file( $fileTmpName,$file_dest)) {
                         # code...
                         $user_id= $_SESSION['user_id'];
                         $uploadDir = "uploads/";
                         $queryz= $mysqli->query("SELECT profile_cover FROM users WHERE user_id= $user_id");
                         $rowz= $queryz->fetch_assoc();
                         $filez= $rowz['profile_cover'] ;

                          if (file_exists($filez) == true ) { 
                                unlink($filez);
                                echo "<script>alert('file deleted')</script>";
                          }else{
                              echo "<script>alert('file was uploaded')</script>";
                          }
        
                        //   if (!unlink($filez)) {
                        //     echo "<script>alert('file was not deleted')</script>";
                        //     }else{ echo "<script>alert('file deleted')</script>";}
                       }
                    return substr($file_dest,22);
                 }else {
                      switch ($files['error']) {

                        case 2:
                             $GLOBALS['imageError']= $files['name'].' <span style = "color:red";>is too big</span>';
                            break;
                         case 4:
                             $GLOBALS['imageError']= $files['name'].' <span style = "color:red";>No file selected</span>';
                            break;
                        default:
                             $GLOBALS['imageError']= $files['name'].' <span style = "color:red";>sorry that type of file is not allowed</span>';
                            break;
                       }
                 }
             }

        }else {
                $GLOBALS['imageError']="the extension is not allowed";
        }
    }

    public function timeAgo($datetime)
    {
        $mysqli= $this->database;
        $stmt = $mysqli->stmt_init();
        $time= strtotime($datetime);
        $current= time($datetime);
        $second= $current - $time;
        $minute= round($second / 60);
        $hour= round($second / 3600);
        $month= round($second / 2600640);

        if ($second <= 60) {
            # code...
             if ($second == 0 ) {
                 # code...
                 return 'now'; 
              }else {
                  # code...
                  return $second.'s'; 
              }

        }elseif ($minute <= 60) {
            # code...
             return $minute.'m'; 
        }elseif ($hour <= 24) {
            # code...
             return $hour.'h'; 

        }elseif ($month <= 12) {
            # code...
             return date('M j',$time); 

        }else { 
            # code...
             return date('j M Y',$time); 
        }

    }

}

$dbs=$db->getConnection();
global $dbs;
$users= new User($dbs);
?>