<?php 

class Notification extends Homepage 
{
    public function getNotificationCount($user_id)
    {
       $mysqli= $this->database;
       $query="SELECT COUNT(message_id) AS totalmessage, (SELECT COUNT(notification_id) FROM notification WHERE notification_for = $user_id AND status ='0') AS totalnotification FROM message WHERE message_to= $user_id AND status= '0' ";
       $result=$mysqli->query($query);
       $data=array();
       while ($row = $result->fetch_assoc()) {
                $data[]= $row;
       }
    //    var_dump($data);
       foreach ($data as $notifiCount) {
           # code...
           return $notifiCount;
       }
    }

    public function messagesView($user_id)
    {
       $mysqli= $this->database;
       $query="UPDATE message SET status = '1' WHERE message_to = $user_id AND status= '0'";
       $result=$mysqli->query($query);
    }

    public function notificationsView($user_id)
    {
       $mysqli= $this->database;
       $query="UPDATE notification SET status = '1' WHERE notification_for = $user_id AND status= '0'";
       $result=$mysqli->query($query);
    }

    public function notifications($user_id)
    {
       $mysqli= $this->database;
       $query="SELECT * FROM notification N 
                        LEFT JOIN users U ON N. notification_from = U. user_id 
                        LEFT JOIN tweety T ON N. target = T. tweet_id
                        LEFT JOIN likes L ON N. target = L. like_on
                        LEFT JOIN follow F ON N. notification_from = F. sender AND N. notification_for = F. receiver 
                        WHERE N. notification_for = $user_id AND N. notification_from != $user_id ";
       $result=$mysqli->query($query);
       $data=array();
        while ($row = $result->fetch_assoc()) {
                 $data[]= $row;
               }
       return $data;
    //    foreach ($data as $notific) {
    //        # code...
    //        return $notific;
    //     }
      //   return $data;
    }

   //  public function SendNotifications($get_id,$user_id,$target,$type)
   //  {
   //     $mysqli= $this->database;
   //     $this->creates('notification',array('notification_for' => $get_id, 'notification_from' => $user_id, 'target' => $target, 'type' => $type ,'time' => date('Y-m-d H-i-s')));
   //  }

    static public function SendNotifications($get_id,$user_id,$target,$type)
    {
       $mysqli= self::$databases;
       self::createss('notification',array('notification_for' => $get_id, 'notification_from' => $user_id, 'target' => $target, 'type' => $type ,'time' => date('Y-m-d H-i-s')));
    }


}

$notification = new Notification($dbs);
?>