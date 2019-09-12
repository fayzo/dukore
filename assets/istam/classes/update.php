<?php 

// INSERT ... ON DUPLICATE KEY UPDATE
// You will need to write very complicated conditions if you want to update more than two rows. In such a case you can use INSERT ... ON DUPLICATE KEY UPDATE approach.

// INSERT into `mytable` (id, fruit, drink, food)
// VALUES
//     ('orange', 'water', 'pizza'),
//     ('strawberry', 'wine', 'fish'),
//     ('peach', 'jiuce', 'cake')
// ON DUPLICATE KEY UPDATE
//     fruit = VALUES(fruit), 
//     drink = VALUES(drink), 
//     food = VALUES(food);

/* *********************************************** */
/* *********************************************** */
/* *********************************************** */
/* *********************************************** */

// UPDATE mytable SET
//     fruit = CASE WHEN id=1 THEN 'orange' ELSE 'strawberry' END,
//     drink = CASE WHEN id=1 THEN 'water'  ELSE 'wine'       END,
//     food  = CASE WHEN id=1 THEN 'pizza'  ELSE 'fish'       END
// WHERE id IN (1,2);

// Personally, using CASE WHEN THEN END looks clumsy.

// You could code this using the IF function.

// UPDATE mytable SET
//     fruit = IF(id=1,'orange','strawberry'),
//     drink = IF(id=1,'water','wine'),
//     food  = IF(id=1,'pizza','fish')
// WHERE id IN (1,2);

/* *********************************************** */
/* *********************************************** */
/* *********************************************** */
/* *********************************************** */

UPDATE `table` SET

`column1` = CASE
WHEN `id`='1034786' THEN '0'
WHEN `id`='1037099' THEN '0'
WHEN `id`='1034789' THEN '3'
ELSE `column1` END,

`column2` = CASE
WHEN `id`='1034786' THEN NULL
WHEN `id`='1037099' THEN '1034789'
WHEN `id`='1034789' THEN '1034789'
ELSE `column2` END,

`column3` = CASE
WHEN `id`='1034786' THEN 'Text One'
WHEN `id`='1037099' THEN 'Text Two'
WHEN `id`='1034789' THEN 'Text Three'
ELSE `column3` END

WHERE `id`='1034786' OR `id`='1037099' OR `id`='1034789'

// Update values we got from somewhere
$update_values = Array(
  '1034786' => Array('column1' => 0, 'column2' => NULL, 'column3'=> 'Text One'),
  '1037099' => Array('column1' => 0, 'column2' => 1034789 , 'column3'=> 'Text Two'),
  '1034789' => Array('column1' => 3, 'column2' => 1034789 , 'column3'=> 'Text Three')
);

// Start of the query
$update_query = "UPDATE `table` SET ";

// Columns we will be updating
$columns = Array('column1' => '`column1` = CASE ', 'column2' => '`column2` = CASE ', 'column3' => '`column3` = CASE ');

// Build up each columns CASE statement
foreach($update_values as $id => $values){
  $columns['column1'] .= "WHEN `id`='" . mysql_real_escape_string($id) . "' THEN '" . mysql_real_escape_string($values['column1']) . "' ";
  $columns['column2'] .= "WHEN `id`='" . mysql_real_escape_string($id) . "' THEN "  . ($values['column2'] === NULL ? "NULL" : "'".mysql_real_escape_string($values['column1'])."'") . " ";
  $columns['column3'] .= "WHEN `id`='" . mysql_real_escape_string($id) . "' THEN '" . mysql_real_escape_string($values['column3']) . "' ";
}

// Add a default case, here we are going to use whatever value was already in the field
foreach($columns as $column_name => $query_part){
  $columns[$column_name] .= " ELSE `$column_name` END ";
}

// Build the WHERE part. Since we keyed our update_values off the database keys, this is pretty easy
$where = " WHERE `id`='" . implode("' OR `id`='", array_keys($update_values)) . "'";

// Join the statements with commas, then run the query
$update_query .= implode(', ',$columns) . $where;
mysql_query($update_query) or die(mysql_error());
?>