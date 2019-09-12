<?php 

class Message extends User 
{
    public function recentMessage($user_id)
    {
       $mysqli= $this->database;
       $query="SELECT * FROM message LEFT JOIN users ON message_from= user_id WHERE message_to= $user_id";
       $result=$mysqli->query($query);
       $data=array();
       while ($row = $result->fetch_array()) {
                $data[]= $row;
       }
    //    var_dump($data);
       return $data;

    }

     public function getMessage($messagefrom,$user_id)
    {
       $mysqli= $this->database;
       $query="SELECT * FROM message LEFT JOIN users ON message_from= user_id WHERE message_from= $messagefrom AND message_to= $user_id OR message_to= $messagefrom AND message_from= $user_id";
       $result=$mysqli->query($query);
       $data=array();
       while ($row = $result->fetch_array()) {
                $data[]= $row;
       }
       foreach ($data as $message) {
           # code...
           if ($message['message_from'] == $user_id) {
               # code...
               echo '
                <!-- Chat messages-->
                
                 <!-- Main message BODY RIGHT START -->
                <div class="main-msg-body-right">
                		<div class="main-msg">
                            <div class="msg-img">
                             '.((!empty($message['profile_image']))?'
                                    <a href="#"><img src="'.BASE_URL.$message['profile_image'].'"/></a>
                                    ':'
                                    <a href="#"><img src="'.BASE_URL.NO_PROFILE_IMAGE_URL.'"/></a>
                                ').'
                			</div>
                			<div class="msg">'.$message['message'].'
                				<div class="msg-time">
                				  '.$this->timeAgo($message['message_on']).'
                				</div>
                			</div>
                			<div class="msg-btn">
                				<a><i class="fa fa-ban" aria-hidden="true"></i></a>
                				<a class="deleteMsg" data-message="'.$message['message_id'].'"><i class="fa fa-trash" aria-hidden="true"></i></a>
                			</div>
                		</div>
                	</div>
                	<!--Main message BODY RIGHT END--> ';
           }else {
               # code...
               echo '
               <!--Main message BODY LEFT START-->
                		<div class="main-msg-body-left">
                			<div class="main-msg-l">
                                <div class="msg-img-l">
                                '.((!empty($message['profile_image']))?'
                                    <a href="#"><img src="'.BASE_URL.$message['profile_image'].'"/></a>
                                    ':'
                                    <a href="#"><img src="'.BASE_URL.NO_PROFILE_IMAGE_URL.'"/></a>
                                ').'
                				</div>
                				<div class="msg-l">'.$message['message'].'
                					<div class="msg-time-l">
                					    '.$this->timeAgo($message['message_on']).'
                					</div>	
                				</div>
                				<div class="msg-btn-l">	
                					<a><i class="fa fa-ban" aria-hidden="true"></i></a>
                					<a class="deleteMsg" data-message="'.$message['message_id'].'"><i class="fa fa-trash" aria-hidden="true"></i></a>
                				</div>
                			</div>
                		</div> 
                	<!--Main message BODY LEFT END-->
                <!-- Chat  --> ';
           }
       }
    }
    
     public function deleteMsg($message_id,$user_id)
    {
        $mysqli= $this->database;
        $query= "DELETE FROM message WHERE message_id = $message_id AND message_from = $user_id OR message_id = $message_id AND message_to = $user_id";
        $mysqli->query($query);
        // var_dump($table);
        // var_dump($array);
        // var_dump($query);
        var_dump( $mysqli->query($query));

    }
}


$message= new Message($dbs);

/*
===========================================
         Notice
===========================================
# You are free to run the software as you wish
# You are free to help yourself study the source code and change to do what you wish
# You are free to help your neighbor copy and distribute the software
# You are free to help community create and distribute modified version as you wish

We promote Open Source Software by educating developers (Beginners)
use PHP Version 5.6.1 > 7.3.20  
===========================================
         For more information contact
=========================================== 
Kigali - Rwanda
Tel : (250)787384312 / (250)787384312
E-mail : shemafaysal@gmail.com

*/
?>