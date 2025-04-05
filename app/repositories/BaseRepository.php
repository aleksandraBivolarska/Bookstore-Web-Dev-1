<?php

class BaseRepository {
    protected $connection;

    function __construct(){
        require __DIR__ . '/../dbconfig.php';

        try {
            $this->connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
    }
        public function beginTransaction() {
            $this->connection->beginTransaction();
        }
        
        public function commit() {
            $this->connection->commit();
        }
        
        public function rollBack() {
            $this->connection->rollBack();
        }
        
}
?>