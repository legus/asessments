<?php
class Database{
 
    private $db_url="../data/";
    public $conn;
 
    // get the database connection
    public function getConnection(){
 
        $this->conn = null;
 
        if (is_dir($this->db_url)) {
            $this->conn=$this->db_url;
        }
 
        return $this->conn;
    }
}
?>