<?php
class Db 
{
    protected $connection;
    static protected $instance;


    static public function getInstance(){
        if (!self::$instance) {
            self::$instance= new self();
        }
      return self::$instance;
    }

    public function __construct(){
        $dbHost = "localhost";
        $dbPort = 3308;
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "tweet";
        $this->connection= new Mysqli($dbHost, $dbUsername, $dbPassword, $dbName,$dbPort);

         if (mysqli_connect_errno()) {
	        die("database connection failed:" .mysqli_connect_error()."(".mysqli_connect_errno().")");
        }else{
            // echo "is OK";
        }
    }

    public function getConnection(){
        return $this->connection;
    }

    public function closeDb(){
        if (isset($this->connection)) {
            $this->connection->close();
            unset($this->connection);
        }
    }
}
$db= new Db();
$db->getConnection();
global $db;
?>