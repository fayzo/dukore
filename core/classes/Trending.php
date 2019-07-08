<?php 
class Trending extends Homepage 
{
     public function trends()
    {
       $mysqli= $this->database;
       $query= "SELECT *, COUNT(tweet_id) AS tweetycounts FROM trends INNER JOIN tweety ON status LIKE CONCAT('%#',hashtag,'%') OR retweet_msg LIKE CONCAT('%#',hashtag,'%') GROUP BY hashtag ORDER BY tweet_id";
       $result=$mysqli->query($query);
       echo '<div class="trend-wrapper"><div class="trend-inner"><div class="trend-title"><h3>Trends</h3></div><!-- trend title end-->';
       while ($trend= $result->fetch_array()) {
           # code...
           echo '<div class="trend-body">
                	<div class="trend-body-content">
                		<div class="trend-link">
                			<a href="'.BASE_URL.$trend['hashtag'].'.hashtag">#'.$trend['hashtag'].'</a>
                		</div>
                		<div class="trend-tweets">
                			'.$trend['tweetycounts'].'<span>tweets</span>
                		</div>
                	</div>
                </div>
                <!--Trend body end--> ';

       }
       echo '</div><!--TREND INNER END--></div><!--TRENDS WRAPPER ENDS-->';
    }

    public function getTweetsTrendbyhastag($hashtag)
    {
       $mysqli= $this->database;
       $query= "SELECT * FROM tweety LEFT JOIN users ON tweetBy= user_id WHERE status LIKE '%#".$hashtag."%' OR retweet_msg LIKE '%#".$hashtag."%' ";
       $result= $mysqli->query($query);
       $tweets_hashtag = array();
       while ($row = $result->fetch_assoc()) {
            /* TABLE OF tweety */
         $tweets_hashtag[] = $row;
      }
       return $tweets_hashtag;

    } 

    public function getUsersHashtag($hashtag)
    {
      $mysqli = $this->database;
      $query = "SELECT DISTINCT * FROM tweety LEFT JOIN users ON tweetBy= user_id WHERE status LIKE '%#" . $hashtag . "%' OR retweet_msg LIKE '%#" . $hashtag . "%' GROUP BY user_id";
      $result = $mysqli->query($query);
      $users_hashtag = array();
      while ($row = $result->fetch_assoc()) {
            /* TABLE OF tweety */
         $users_hashtag[] = $row;
      }
      return $users_hashtag;
    }
}

$dbs=$db->getConnection();
$trending = new Trending($dbs);
?>