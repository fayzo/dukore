<?php 
class Comment extends User 
{
    public function comments($tweet_id)
    {
         $mysqli= $this->database;
        // $stmt = $mysqli->stmt_init();
        // $query= "SELECT * FROM tweety, users WHERE tweet_id = $tweet_id AND tweetBy =$user_id";
        $query= "SELECT * FROM comment LEFT JOIN users ON comment_by=user_id WHERE comment_on = $tweet_id ";
        $result= $mysqli->query($query);
        $comments= array();
        while ($row= $result->fetch_assoc()) {
             $comments[] = $row;
        }
       
        return $comments;
        
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
        // var_dump($table);
        // var_dump($array);
        // var_dump($query);
        var_dump( $mysqli->query($query));

    }
}

$dbs=$db->getConnection();
$comment= new Comment($dbs);
?>