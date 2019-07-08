<?php 

class Homepage extends User 
{
    public function getUserTweet($user_id)
    {
        $mysqli= $this->database;
        $stmt = $mysqli->stmt_init();
        // $query= "SELECT COUNT('tweet_id') AS TotalTweets FROM tweety WHERE tweetBy = $user_id AND retweet_id = 0 OR retweet_by= $user_id";
        $query= "SELECT * FROM tweety LEFT JOIN users ON tweetBy = user_id WHERE tweetBy = ? AND retweet_id = 0 OR retweet_by= ?";
        $stmt->prepare($query);
        $stmt->bind_param('ii', $user_id, $user_id);
        $stmt->execute();
        $stmt->bind_result($tweet_id, $status, $tweetBy, $retweet_id, $retweet_by, $tweet_image,
        $likes_counts, $retweet_counts, $posted_on, $retweet_msg,
        $user_idd,$username,$email,$password,$screenname,$profile_image,$profile_cover,$followers,$following,$bio,$country,$website);
        $all_tweet=array();
        while ($stmt->fetch()) {
            $data = array();
            /* TABLE OF tweety */
            $data["tweet_id"]=$tweet_id;
            $data["status"]=$status;
            $data["tweetBy"]=$tweetBy;
            $data["retweet_id"]=$retweet_id;
            $data["retweet_by"]=$retweet_by;
            $data["tweet_image"]=$tweet_image;
            $data["likes_counts"]=$likes_counts;
            $data["retweet_counts"]=$retweet_counts;
            $data["posted_on"]=$posted_on;
            $data["retweet_msg"]=$retweet_msg;
            /* TABLE OF USERS */
            $data["user_id"]=$user_idd;
            $data["username"]=$username;
            $data["email"]=$email;
            $data["password"]=$password;
            $data["screenname"]=$screenname;
            $data["profile_image"]=$profile_image;
            $data["profile_cover"]=$profile_cover;
            $data["followers"]=$followers;
            $data["following"]=$following;
            $data["bio"]=$bio;
            $data["country"]=$country;
            $data["website"]=$website;
            array_push($all_tweet, $data);
        }
            return $all_tweet;

    }

    public function countsTweet($user_id)
    {
        $mysqli= $this->database;
        $stmt = $mysqli->stmt_init();
        // $query= "SELECT COUNT('tweet_id') AS TotalTweets FROM tweety WHERE tweetBy = $user_id AND retweet_id = 0 OR retweet_by= $user_id";
        $query= "SELECT COUNT('tweet_id') AS TotalTweets FROM tweety WHERE tweetBy = ? AND retweet_id = 0 OR retweet_by= ?";
        $stmt->prepare($query);
        $stmt->bind_param('ii', $user_id, $user_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $counts_tweet = array();
        //  $result=$mysqli->query($query);
        //  $row=$result->fetch_array();
        //  return $row['TotalTweets'];
        while ($stmt->fetch()) {
            $data = array();
            /* TABLE OF tweety */
            $data["TotalTweets"]= $count;
            array_push($counts_tweet, $data);
        }
        foreach ($counts_tweet as $counts_tweets) {
            return $counts_tweets["TotalTweets"];
        }
    }

    public function countsLike($user_id)
    {
        $mysqli= $this->database;
        $stmt = $mysqli->stmt_init();
        $query= "SELECT COUNT('like_id') AS TotalLikes FROM likes WHERE like_by = ?";
        // $query= "SELECT COUNT('like_id') AS TotalLikes FROM likes WHERE like_by = $user_id";
        $stmt->prepare($query);
        $stmt->bind_param('i', $user_id);
        $stmt->bind_result($count);
        $stmt->execute();
        //  $result=$mysqli->query($query);
        //  $row=$result->fetch_array();
        //  return $row['TotalLikes'];
        $counts_likes = array();
        while ($stmt->fetch()) {
            $data = array();
            /* TABLE OF tweety */
            $data["TotalLikes"]=$count;
            array_push($counts_likes, $data);
        }
        foreach ($counts_likes as $counts_like) {
              return $counts_like["TotalLikes"];
        }
    }


    public function getPopupTweet($user_id,$tweet_id,$tweet_by)
    {
        $mysqli= $this->database;
        $query= "SELECT * FROM tweety, users WHERE tweet_id = $tweet_id AND tweetBy = user_id";
        $result= $mysqli->query($query);
        while ($row= $result->fetch_array()) {
            # code...
            return $row;
        }
    }

    public function retweet($retweet_id,$user_id,$tweet_by,$comments)
    {
        $mysqli= $this->database;
        $stmt = $mysqli->stmt_init();
        $query= "UPDATE tweety SET retweet_counts = retweet_counts +1  WHERE tweet_id= ? ";
        // $mysqli->query($query); 
        $stmt->prepare($query);
        $stmt->bind_param('i',$retweet_id);
        $stmt->execute();

        $query= "INSERT INTO tweety (status, tweetBy, retweet_id, retweet_by, tweet_image, likes_counts, retweet_counts, posted_on, retweet_msg) 
        SELECT status, tweetBy, ?, ?, tweet_image, likes_counts, retweet_counts, posted_on, ?  FROM tweety WHERE tweet_id= ? ";
        // $mysqli->query($query);
        $stmt->prepare($query);
        $stmt->bind_param('iisi', $retweet_id, $user_id, $comments, $retweet_id);
        $stmt->execute();  

        $query= "DELETE FROM tweety WHERE tweet_id= ?";
        $stmt->prepare($query);
        // $last_id= $stmt->insert_id;  
        $stmt->bind_param('i',$stmt->insert_id);
        Notification::SendNotifications($tweet_by,$user_id, $retweet_id,'retweet');
        return $stmt->execute();
        // return $mysqli->query($query); 
    }

    public function checkRetweet($tweet_id,$user_id)
    {
        $mysqli= $this->database;
        $stmt = $mysqli->stmt_init();
        $query="SELECT * FROM tweety WHERE retweet_id= ?  AND retweet_by= ? OR tweet_id=? AND retweet_by=? ";
        $stmt->prepare($query);
        $stmt->bind_param('iiii', $tweet_id, $user_id, $tweet_id, $user_id);
        $stmt->bind_result($tweet_idd, $status, $tweetBy, $retweet_idd, $retweet_by, $tweet_image,
        $likes_counts, $retweet_counts, $posted_on, $retweet_msg);
        $stmt->execute();
        $CountRetweet= array();
        while ($stmt->fetch()) {
             $CountRetweet[] = array(
              /* TABLE OF tweety */
             "tweet_id" => $tweet_idd,
             "status" => $status,
             "tweetBy" => $tweetBy,
             "retweet_id" => $retweet_idd,
             "retweet_by" => $retweet_by,
             "tweet_image" => $tweet_image,
             "likes_counts" => $likes_counts,
             "retweet_counts" => $retweet_counts,
             "posted_on" => $posted_on,
             "retweet_msg" => $retweet_msg,
           );
        }
        foreach ($CountRetweet as $countsRetweet) {
            # code...
            return $countsRetweet; // Return the $contacts array
        }


    }

    public function likes($user_id,$tweet_id)
    {
        $mysqli= $this->database;
        $stmt = $mysqli->stmt_init();
        $query= "SELECT * FROM likes WHERE like_by = ? AND like_on = ?";
        $stmt->prepare($query);
        $stmt->bind_param('ii', $user_id, $tweet_id);
        $stmt->bind_result($like_id, $like_by, $like_on);
        $stmt->execute();
        // $CountLikes= array();
        // $fetchCountLikes= array();

        // while ($stmt->fetch()) {
        //     # code...
        //     $fetchCountLikes['like_id']= $like_id;
        //     $fetchCountLikes['like_by']= $like_by;
        //     $fetchCountLikes['like_on']= $like_on;
        //     // array_push($CountLikes,$fetchCountLikes);
        // }
        $fetchCountLikes= array();
        while ($stmt->fetch()) {
             $fetchCountLikes[] = array(
            'like_id' => $like_id,
            'like_by' => $like_by,
            'like_on' => $like_on
           );
        }
        foreach ($fetchCountLikes as $fetchLikes) {
            # code...
            return $fetchLikes; // Return the $contacts array
        }
        // return $fetchLikes;
    //    echo var_dump($CountLikes);
    }
    public function unLike( $user_id,$tweet_id, $get_id)
    {
        $mysqli= $this->database;
        $stmt = $mysqli->stmt_init();
        $query= "UPDATE tweety SET likes_counts = likes_counts -1 WHERE tweet_id= ? ";
        $stmt->prepare($query);
        $stmt->bind_param('i',$tweet_id);
        $stmt->execute();

        $query= "DELETE FROM likes WHERE like_by = ? AND like_on = ?";
        $stmt->prepare($query);
        $stmt->bind_param('ii', $user_id, $tweet_id);
        $stmt->execute();
    }

    public function addLike($user_id,$tweet_id,$get_id)
    {
        $mysqli= $this->database;
        $stmt = $mysqli->stmt_init();
        $query= "UPDATE tweety SET likes_counts = likes_counts +1 WHERE tweet_id= ? ";
        $stmt->prepare($query);
        $stmt->bind_param('i',$tweet_id);
        $stmt->execute();
        $this->creates('likes',array('like_by' => $user_id ,'like_on' => $tweet_id));
        if ($get_id != $user_id) {
            Notification::SendNotifications($get_id,$user_id,$tweet_id,'likes');
        }
    }

    public function getTweetLink($tweet)
    {
        $tweet= preg_replace('/(http:\/\/)([\w+.])([\w.]+)/','<a href="$0" target="_blink">$0</a>',$tweet);
        $tweet= preg_replace('/#([\w]+)/','<a href="'.BASE_URL.'$1.hashtag" >$0</a>',$tweet);
        $tweet= preg_replace('/@([\w]+)/','<a href="'.BASE_URL.'$1">$0</a>',$tweet);
        return  $tweet;
    }
    
    public function addTrends($hashtag)
    {
        $mysqli= $this->database;
        $stmt = $mysqli->stmt_init();
        preg_match_all('/#+([a-zA-Z0-9_]+)/i',$hashtag, $matches);
        if ($matches) {
            # code...
            $resuslt= array_values($matches[1]);
        }
        $query = "INSERT INTO trends ( hashtag, create_on) VALUES(?,CURRENT_TIMESTAMP)";
        foreach ($resuslt as $trend) {
            # code...
            if ($stmt->prepare($query)) {
                  $stmt->bind_param('s',$trend);
                  $stmt->execute();
            }
        }

    }

    public function addmention($status,$user_id,$tweet_id)
    {
        $mysqli= $this->database;
        preg_match_all('/@+([a-zA-Z0-9_]+)/i',$status, $matches);
        if ($matches) {
            # code...
            $result= array_values($matches[1]);
        }
        foreach ($result as $username) {
            # code...
                $query = "SELECT * FROM users WHERE username ='$username' ";
                $res = $mysqli->query($query);
                $data= $res->fetch_assoc();
                if ($data['user_id'] != $user_id ) {
                    Notification::SendNotifications($data['user_id'],$user_id,$tweet_id,'mention');
                }
            }
    }

    public function getmention($mention)
    {
        $mysqli= $this->database;
        $stmt = $mysqli->stmt_init();
        $query = "SELECT user_id, username , screenname, profile_image FROM users WHERE username LIKE ? OR screenname LIKE ? LIMIT 5";
        $stmt->prepare($query);
        $param= '%'.$mention.'%';
        $stmt->bind_param('ss',$mention,$mention);
        $stmt->execute();
        $stmt->bind_result($user_id,$username,$screenname,$profile_image);
        $trendMention = array();
        while ($stmt->fetch()) {
            $trendMention[] = array(
            'user_id' => $user_id,
            'username' => $username,
            'screenname' => $screenname,
            'profile_image' => $profile_image
           );
        }
        return $trendMention; // Return the $contacts array
        $stmt->close();
    }

    public function getTrendshashtag($trend)
    {
        $mysqli= $this->database;
        $stmt = $mysqli->stmt_init();
        $query = "SELECT * FROM trends WHERE hashtag LIKE ? LIMIT 5";
        $stmt->prepare($query);
        $param= '%'.$trend.'%';
        $stmt->bind_param('s',$trend);
        $stmt->execute();

        $stmt->bind_result($trend_id, $hashtag, $create0n);
        $trendshash = array();
        while ($stmt->fetch()) {
            $trendshash[] = array(
            'trend_id' => $trend_id,
            'hashtag' => $hashtag,
            'create_on' => $create0n
           );
        }
        return $trendshash; // Return the $contacts array
        $stmt->close();
    }
    public function tweet($user_id,$limit)
    {
        // global $db;
        // $mysqli=$db->getconnection();
        $mysqli= $this->database;
        $stmt = $mysqli->stmt_init();
        // $query = "SELECT * FROM tweety , users WHERE tweetBy= ? AND user_id= ?";
        // $query = "SELECT * FROM tweety , users WHERE tweetBy=user_id";
        $query = "SELECT * FROM tweety LEFT JOIN users ON tweetBy=user_id WHERE tweetBy=? AND retweet_id='0' OR tweetBy=user_id AND retweet_by != ? AND tweetBy IN (SELECT receiver FROM follow WHERE sender = ? ) ORDER BY tweet_id DESC LIMIT ?";
        $stmt->prepare($query);
        // $stmt->result_metadata();
        // $metadata->fetch_field();
        // $user_id= $_SESSION['user_id'];
        $stmt->bind_param('iiii', $user_id, $user_id, $user_id,$limit);
        $stmt->bind_result($tweet_id, $status, $tweetBy, $retweet_id, $retweet_by, $tweet_image,
        $likes_counts, $retweet_counts, $posted_on, $retweet_msg,
        $user_idd,$username,$email,$password,$screenname,$profile_image,$profile_cover,$followers,$following,$bio,$country,$website);
        $stmt->execute();
        $tweets = array();
        while ($stmt->fetch()) {
            $data = array();
            /* TABLE OF tweety */
            $data["tweet_id"]=$tweet_id;
            $data["status"]=$status;
            $data["tweetBy"]=$tweetBy;
            $data["retweet_id"]=$retweet_id;
            $data["retweet_by"]=$retweet_by;
            $data["tweet_image"]=$tweet_image;
            $data["likes_counts"]=$likes_counts;
            $data["retweet_counts"]=$retweet_counts;
            $data["posted_on"]=$posted_on;
            $data["retweet_msg"]=$retweet_msg;
            /* TABLE OF USERS */
            $data["user_id"]=$user_idd;
            $data["username"]=$username;
            $data["email"]=$email;
            $data["password"]=$password;
            $data["screenname"]=$screenname;
            $data["profile_image"]=$profile_image;
            $data["profile_cover"]=$profile_cover;
            $data["followers"]=$followers;
            $data["following"]=$following;
            $data["bio"]=$bio;
            $data["country"]=$country;
            $data["website"]=$website;
            
            array_push($tweets, $data);

        }
        // $tweets= $stmt->fetch();
        foreach ($tweets as $tweet) {
            # code...
            $tweet_likes= $this->likes($user_id,$tweet['tweet_id']);
            $Retweet= $this->checkRetweet($tweet['tweet_id'], $user_id);
            $user= $this->userData($tweet['retweet_by']);
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
                         			<span>'.$this->timeAgo($tweet['posted_on']).'</span>
                         		</div>
                         		<div class="t-h-c-dis">
                         			'.$this->getTweetLink($tweet['retweet_msg']).'
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
                         					<span>'.$this->timeAgo($tweet['posted_on']).'</span>
                         				</div>
                         				<div class="retweet-t-s-b-inner-right-text">		
                         					'.$this->getTweetLink($tweet['status']).'
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
                    					<span>'.$this->timeAgo($tweet["posted_on"]).'</span>
                                    </div>
                                    <div class="t-h-c-dis">
                                      '.$this->getTweetLink($tweet["status"]).'
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
                                                <li>'.(($tweet['tweet_id'] == $Retweet["retweet_id"])? '<button class="retweeted" data-tweet="'.$tweet["tweet_id"].'"  data-user="'.$tweet["tweetBy"].'" ><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetcounter" >'.$Retweet["retweet_counts"].'</span></button>':'<button class="retweet" data-tweet="'.$tweet["tweet_id"].'"  data-user="'.$tweet["tweetBy"].'" ><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetcounter" >'.(($Retweet["retweet_counts"] > 0)? $Retweet["retweet_counts"] :'' ).'</span></button>').'</li>
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

        }
    }

    public function creates($table,$fields=array())
    {
        // global $db;
        // $mysqli=$db->getconnection();
        $mysqli= $this->database;
        // $query = 'INSTERT INTO `first_page_data` (';
        // foreach ($array as $key => $value) {
        //     $query .= '`' . $key . '`';
        // }
        // $query .= ') VALUES (';
        // foreach ($array as $value) {
        //     $query .= '`' . $value . '`';
        // }
        // $query .= ')';

        function addQuotes($str){
            return "'$str'";
        }
         $valued = array();
        # Surround values by quotes
        foreach ($fields as $key => $value) {
            $valued[] = addQuotes($value);
        }
        
        # Build the column
        $columns = implode(",", array_keys($fields));
        
        # Build the values
        $values = implode(",", array_values($valued));
        
        # Build the insert query
        $queryl = "INSERT INTO $table (".$columns.") VALUES (".$values.")";
        $query= $mysqli->query($queryl);

        // var_dump($queryl);
        $row= json_encode($mysqli->insert_id);
        return $row;
    }

    static public function createss($table,$fields=array())
    {
        // global $db;
        // $mysqli=$db->getconnection();
        $mysqli= self::$databases;
        // $query = 'INSTERT INTO `first_page_data` (';
        // foreach ($array as $key => $value) {
        //     $query .= '`' . $key . '`';
        // }
        // $query .= ') VALUES (';
        // foreach ($array as $value) {
        //     $query .= '`' . $value . '`';
        // }
        // $query .= ')';

        function addQuotess($str){
            return "'$str'";
        }
         $valued = array();
        # Surround values by quotes
        foreach ($fields as $key => $value) {
            $valued[] = addQuotess($value);
        }
        # Build the column
        $columns = implode(",", array_keys($fields));
        
        # Build the values
        $values = implode(",", array_values($valued));
        
        # Build the insert query
        $queryl = "INSERT INTO $table (".$columns.") VALUES (".$values.")";
        $query= $mysqli->query($queryl);

        // var_dump($queryl);
        
    }

    function create($table,$exclude = array()) 
    {
        // global $db;
        // $mysqli=$db->getconnection();
        $mysqli=$this->database;
        $fields = $values = array();
    
        if( !is_array($exclude) ) $exclude = array($exclude);
    
        foreach( array_keys($exclude) as $key ) {
            if( !in_array($key, $exclude) ) {
                $fields[] = "`$key`";
                $values[] = "'" .$mysqli->real_escape_string($exclude[$key]). "'";
            }
        }
    
        $fields = implode(",", $fields);
        $values = implode(",", $values);

        $queryl="INSERT INTO `$table` ($fields) VALUES ($values)";
        $query= $mysqli->query($queryl);
        var_dump($query);
    
        if($query) {
            return array( "mysqli_error" => $mysqli->error,
                          "mysqli_insert_id" => $mysqli->insert_id,
                          "mysqli_affected_rows" => $mysqli->affected_rows,
                          "mysqli_info" => $mysqli->info
                        );
        } else {
            return array( "mysqli_error" => $mysqli->error );
        }


   }

     public function uploadImageProfiles($files)
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
                    //  $file_dest= 'uploads/posts/'.$filenames;
                     $file_dest= $_SERVER['DOCUMENT_ROOT'].'tweet/'.'uploads/posts/'.$filenames;
                     move_uploaded_file($fileTmpName,$file_dest);
                    //  if (move_uploaded_file($fileTmpName,$file_dest)) {
                         # code...
                        //  $user_id= $_SESSION['user_id'];
                        //  $uploadDir = "uploads/profile/";
                        //  $queryz=  $mysqli->query("SELECT profile_image FROM users WHERE user_id='{$user_id}'");
                        //  $rowz= $queryz->fetch_assoc();
                        //  $filez= $rowz['profile_image'] ;

                        //  if (file_exists($filez) == true ) { 
                        //         unlink($filez);
                        //         echo "<script>alert('file deleted')</script>";
                        //   }else{
                        //       echo "<script>alert('file was uploaded')</script>";
                        //   }
                        //   if (!unlink($filez)) {
                        //     echo "<script>alert('file was not deleted')</script>";
                        //     }else{ echo "<script>alert('file deleted')</script>";}
                        // }
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
}

$dbs=$db->getConnection();
$homepage= new Homepage($dbs);
User::getdatabse($dbs);
?>
