<?php 
class Follow extends Homepage 
{
    public function checkfollow($follow_id,$user_id)
    {
       $mysqli= $this->database;
       $query= "SELECT * FROM follow WHERE sender = $user_id AND receiver = $follow_id";
       $result=$mysqli->query($query);
       while ($follow= $result->fetch_array()) {
           # code...
           return $follow;
       }
    }

    public function followBtn($profile_id,$user_id)
    {
       $data= $this->checkfollow($profile_id,$user_id);

       if ($this->loggedin() == true) {
           # code...
           if ($profile_id != $user_id) {
               # code...
               if ($data['receiver'] == $profile_id) {
                   # code...followin Btn
                   return '
                   <button type="button" class="f-btn following-btn follow-btn" data-follow="'.$profile_id.'"  >Following</button>
                   ';
               }else {
                   # code...follow btn
                    return '
                   <button type="button" class="f-btn follow-btn" data-follow="'.$profile_id.'"  ><i class="fa fa-user-plus"></i>Follow</button>
                   ';
               }
           }else {
               # code...
               return ' 
                <button type="button" class="f-btn" onclick=location.href="'.BASE_URL.'profileEdit" >Edit Profile</i></button>
                ';
           }

       }else {
           # code...
          return ' 
           <button type="button" class="f-btn" onclick=location.href="'.BASE_URL.'index.php" ><i class="fa fa-user-plus"></i>Follow</button>
           ';
       }

    }

     public function follows($follow_id,$user_id)
    {
       $mysqli= $this->database;
       $this->creates("follow",array('sender' => $user_id ,'receiver' => $follow_id,'follow_on' => date('Y-m-d H:i:s')));
       $this->addFollowCounts($follow_id,$user_id);
       $query="SELECT * FROM users WHERE user_id= $follow_id";
       $result= $mysqli->query($query);
       $row= $result->fetch_assoc();
       echo json_encode($row);
        Notification::SendNotifications($follow_id,$user_id,$follow_id,'follow');

    }

    public function unfollow($follow_id,$user_id)
    {
       $mysqli= $this->database;
       $this->delete("follow",array('sender' => $user_id ,'receiver' => $follow_id));
       $this->removeFollowCounts($follow_id,$user_id);
       $query="SELECT * FROM users WHERE user_id= $follow_id";
       $result= $mysqli->query($query);
       $row = $result->fetch_assoc();
       echo json_encode($row);
    }

    public function addFollowCounts($follow_id,$user_id)  
    {
        $mysqli= $this->database;
        $query="UPDATE users SET following = CASE user_id 
                                             WHEN $user_id THEN following +1 
                                             ELSE following 
                                           END, 
                                followers = CASE user_id 
                                            WHEN $follow_id THEN followers +1
                                            ELSE followers 
                                          END
                WHERE user_id IN ($user_id, $follow_id)";
                
       $mysqli->query($query);
    }

     public function removeFollowCounts($follow_id,$user_id)
    {
        $mysqli= $this->database;
        $query="UPDATE users SET following = CASE user_id 
                                             WHEN $user_id THEN following -1 
                                             ELSE following 
                                           END, 
                                followers = CASE user_id 
                                            WHEN $follow_id THEN followers -1
                                            ELSE followers 
                                          END
                WHERE user_id IN ($user_id, $follow_id)";
        $mysqli->query($query);
    }

    public function FollowingLists($profile_id,$user_id)
    {
       $mysqli= $this->database;
       $query= "SELECT * FROM users LEFT JOIN follow ON sender= user_id AND CASE WHEN receiver = $profile_id THEN sender = user_id END WHERE receiver IS NOT NULL";
       $result=$mysqli->query($query);
       while ($following=$result->fetch_array()) {
           # code...
           echo '<div class="follow-unfollow-box">
                	<div class="follow-unfollow-inner">
                        <div class="follow-background">
                         '.((!empty($following['profile_cover']))?
                           '<img src="'.BASE_URL.$following['profile_cover'].'"  />'
                          :' <img src="'.BASE_URL.NO_PROFILE_IMAGE_URL.'"  /> ').'
                		</div>
                		<div class="follow-person-button-img">
                			<div class="follow-person-img"> 
                              '.((!empty($following['profile_image']))?
                               '<img src="'.BASE_URL.$following['profile_image'].'"  />'
                              :' <img src="'.BASE_URL.NO_PROFILE_IMAGE_URL.'"  /> ').'
                			</div>
                			<div class="follow-person-button">
                				 '.$this->followBtn($following['user_id'],$user_id,$profile_id).'
                		    </div>
                		</div>
                		<div class="follow-person-bio">
                			<div class="follow-person-name">
                				<a href="'.BASE_URL.$following['username'].'">'.$following['screenname'].'</a>
                			</div>
                			<div class="follow-person-tname">
                				<a href="'.BASE_URL.$following['username'].'">'.$following['username'].'</a>
                			</div>
                			<div class="follow-person-dis">
                				'.$this->getTweetLink($following['bio']).'
                			</div>
                		</div>
                	</div>
                </div> ';
       }

    }

     public function FollowersLists($profile_id,$user_id)
    {
       $mysqli= $this->database;
       $query= "SELECT * FROM users LEFT JOIN follow ON receiver= user_id AND CASE WHEN sender = $profile_id THEN receiver = user_id END WHERE sender IS NOT NULL";
       $result=$mysqli->query($query);
       while ( $following=$result->fetch_array()) {
           # code...
           echo '<div class="follow-unfollow-box">
                	<div class="follow-unfollow-inner">
                        <div class="follow-background">
                         '.((!empty($following['profile_cover']))?
                           '<img src="'.BASE_URL.$following['profile_cover'].'"  />'
                          :' <img src="'.BASE_URL.NO_PROFILE_IMAGE_URL.'"  /> ').'
                		</div>
                		<div class="follow-person-button-img">
                			<div class="follow-person-img"> 
                              '.((!empty($following['profile_image']))?
                               '<img src="'.BASE_URL.$following['profile_image'].'"  />'
                              :' <img src="'.BASE_URL.NO_PROFILE_IMAGE_URL.'"  /> ').'
                			</div>
                			<div class="follow-person-button">
                				 '.$this->followBtn($following['user_id'],$user_id,$profile_id).'
                		    </div>
                		</div>
                		<div class="follow-person-bio">
                			<div class="follow-person-name">
                				<a href="'.BASE_URL.$following['username'].'">'.$following['screenname'].'</a>
                			</div>
                			<div class="follow-person-tname">
                				<a href="'.BASE_URL.$following['username'].'">'.$following['username'].'</a>
                			</div>
                			<div class="follow-person-dis">
                				'.$this->getTweetLink($following['bio']).'
                			</div>
                		</div>
                	</div>
                </div> ';
       }

    }

    public function whoTofollow($user_id)
    {
       $mysqli= $this->database;
       $query= "SELECT * FROM users WHERE user_id != $user_id AND user_id NOT IN (SELECT receiver FROM follow WHERE sender = $user_id ) ORDER BY rand() LIMIT 4";
       $result=$mysqli->query($query);
       $result=$mysqli->query($query);
       
         echo ' <div class="follow-wrap"><div class="follow-inner"><div class="follow-title"><h3>Who to follow</h3></div>';
           while ($whoTofollow=$result->fetch_array()) {

            echo '<div class="follow-body">
                    <div class="follow-img">
                    '.((!empty($whoTofollow['profile_image'])?'
                      <img src="'.BASE_URL.$whoTofollow['profile_image'].'"/>
                      ':'
                      <img src="'.BASE_URL.NO_PROFILE_IMAGE_URL.'"/>
                      ')).'
                    </div>
                	<div class="follow-content">
                		<div class="fo-co-head">
                            <a href="'.BASE_URL.$whoTofollow['username'].'"> 
                                '.((!empty($whoTofollow['screenname'])?'
                                     '.$whoTofollow['screenname'].'
                                 ':'
                                     '.$whoTofollow['username'].'
                                 ')).'
                              </a><span>@'.$whoTofollow['username'].'</span>
                		</div>
                        <!-- FOLLOW BUTTON -->
	                   '.$this->followBtn($whoTofollow['user_id'],$user_id).'
                	</div>
                </div>';
             }

         echo '
                    </div>
                </div> ';
    }
}

$dbs=$db->getConnection();
$follow = new Follow($dbs);
?>