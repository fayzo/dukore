<?php 
// Database configuration
// $dbHost = "localhost";
// $dbUsername = "root";
// $dbPassword = "";
// $dbName = "up";

// // Create database connection
//  $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// // Check connection
// if ($db->connect_error) {
//     die("Connection failed: " . $db->connect_error);
//    }
//  $query="UPDATE myfruit SET follow = CASE id 
//                                              WHEN $user_id THEN follow +1 
//                                              ELSE follow 
//                                            END, 
//                                 followers = CASE id 
//                                             WHEN $follow_id THEN followers +1
//                                             ELSE followers 
//                                           END
//                 WHERE id IN ($user_id, $follow_id)";
// echo $query;

    //  $query=" UPDATE `myfruit` SET
            
    //         `fruit` = CASE
    //                   WHEN `id`='1' THEN '1'
    //                   WHEN `id`='2' THEN '2'
    //                   WHEN `id`='3' THEN '3'
    //                   ELSE `fruit` END,
            
    //         `drink` = CASE
    //                   WHEN `id`='1' THEN NULL
    //                   WHEN `id`='2' THEN '1034789'
    //                   WHEN `id`='3' THEN '1034789'
    //                   ELSE `drink` END,
            
    //         `food` = CASE
    //                   WHEN `id`='1' THEN 'Text One'
    //                   WHEN `id`='2' THEN 'Text Two'
    //                   WHEN `id`='3' THEN 'Text Three'
    //                   ELSE `food` END
            
    //         WHERE `id`='1' OR `id`='2' OR `id`='3'";

    //  echo var_dump($query);
    
     /* ******************* */
     /* ******************* */

    //  // Update values we got from somewhere
    //  $update_values = Array(
    //    '1' => Array('column1' => 0, 'column2' => NULL, 'column3'=> 'Text One'),
    //    '2' => Array('column1' => 0, 'column2' => 1034789 , 'column3'=> 'Text Two'),
    //    '3' => Array('column1' => 3, 'column2' => 1034789 , 'column3'=> 'Text Three')
    //  );

    //  // Start of the query
    //  $update_query = "UPDATE `myfruit` SET ";
     
    //  // Columns we will be updating
    // //  $columns = Array('column1' => '`fruit` = CASE ', 'column2' => '`drink` = CASE ', 'column3' => '`food` = CASE ');
    //  $columns = Array('fruit' => '`fruit` = CASE ', 'drink' => '`drink` = CASE ', 'food' => '`food` = CASE ');
     
    //  // Build up each columns CASE statement
    //  foreach($update_values as $id => $values){
    //    $columns['fruit'] .= "WHEN `id`='" . $db->real_escape_string($id) . "' THEN '" . $db->real_escape_string($values['column1']) . "' ";
    //    $columns['drink'] .= "WHEN `id`='" . $db->real_escape_string($id) . "' THEN "  . ($values['column2'] === NULL ? "NULL" : "'".$db->real_escape_string($values['column1'])."'") . " ";
    //    $columns['food'] .= "WHEN `id`='" . $db->real_escape_string($id) . "' THEN '" . $db->real_escape_string($values['column3']) . "' ";
    //  }

    //  // Add a default case, here we are going to use whatever value was already in the field
    //  foreach($columns as $column_name => $query_part){
    //    $columns[$column_name] .= " ELSE `$column_name` END ";
    //  }
    //  echo var_dump( $columns)."<br>";
    //  // Build the WHERE part. Since we keyed our update_values off the database keys, this is pretty easy
    //  $where = " WHERE `id`='" . implode("' OR `id`='", array_keys($update_values)) . "'";

    //  // Join the statements with commas, then run the query
    //  $update_query .= implode(', ',$columns) . $where;
    //  $query = $update_query;
    //  echo var_dump($query);
         /* ******************* */
         /* ******************* */

    // $query="UPDATE mytable SET
    //            fruit = IF(id=1,'orange','strawberry'),
    //            drink = IF(id=1,'water','wine'),
    //            food  = IF(id=1,'pizza','fish')
    //        WHERE id IN (1,2);

       /* ******************* */
       /* ******************* */
       
    // $query="UPDATE myfruit SET
    //         fruit = CASE WHEN id=1 THEN 'Aorange' ELSE 'Bstrawberry' END,
    //         drink = CASE WHEN id=1 THEN 'Awater'  ELSE 'Bwine'       END,
    //         food  = CASE WHEN id=1 THEN 'Apizza'  ELSE 'Bfish'       END
    //         WHERE id IN (1,2)";

       /* ******************* */
       /* ******************* */

    // $id_table = array(
    //     '1' => 'following',
    //   );
    
    // $id_table1 = array(
    //     '2'=> 'followers'
    //   );
    
    // $str_ids = implode(',', array_keys($id_table));
    // $str_ids1 = implode(',', array_keys($id_table1));
    // echo $str_ids."<br>";
    // echo $str_ids1."<br>";
    // $str_when_then = "";
    // $str_when_then1 = "";
    
    // foreach($id_table as $id => $value) {
    //   $str_when_then .= sprintf(" WHEN '%d' THEN '%s' ",
    //       $id,
    //       $value // note, you'd sanitize this if from user input
    //   );
    // }
    // echo $str_when_then."<br>";
    
    // foreach($id_table1 as $id => $value) {
    //   $str_when_then1 .= sprintf(" WHEN '%d' THEN '%s' ",
    //       $id,
    //       $value // note, you'd sanitize this if from user input
    //   );
    // }
    // echo $str_when_then1."<br>";
    // // whitespace + appends included in example for readability
    // $template =   "UPDATE `myfruit` "
    //             . "SET `fruit` = CASE `id` "
    //             . "%s "
    //             . "END, "
    //             . "`drink` = CASE `id` "
    //             . "%s "
    //             . "END "
    //             . "WHERE `id` IN (%s,%s)";
    
    // echo $template."<br>";
    // $query = sprintf($template, $str_when_then,$str_when_then1, $str_ids, $str_ids1);
    // echo $query."<br>"; 

       /* ******************* */
       /* ******************* */

// $query="INSERT into `myfruit` ( id,fruit, drink, food)
//          VALUES
//             ( 4,'Aorange', 'Awate', 'pizza'),
//             ( 5,'Bstrawberry', 'Bwine', 'fish'),
//             ( 6,'Cpeach', 'Cjiuce', 'cake')
//         ON DUPLICATE KEY UPDATE
//             fruit = VALUES(fruit), 
//             drink = VALUES(drink), 
//             food = VALUES(food)";

       /* ******************* */
       /* ******************* */

// $query="UPDATE myfruit SET
//             fruit = IF(id=1,'Aorange','Dstrawberry'),
//             drink = IF(id=1,'Bwater','Ewine'),
//             food  = IF(id=1,'Cpizza','Ffish')
//         WHERE id IN (1,2)";


// $db->query($query);

?>