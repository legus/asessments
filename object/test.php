<?php
class Test{
 
    // database connection and table name
    private $conn;
    private $table_name = "test";
    private $test_db;
 
    // object properties
    public $test_id;
    public $n_questions;
    public $questions;
    public $time;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
        $temp=$db.$this->table_name.".json";
        $this->test_db=$temp;
        
        if (!file_exists($temp)) {//If it hasn't been created
            $content = array();
            $fp = fopen($temp, 'w');
            fwrite($fp, json_encode($content));
            fclose($fp);
        }
    }

    // create taker
    function create(){
        
        // sanitize
        $this->test_id=htmlspecialchars(strip_tags($this->test_id));
        $this->n_questions=htmlspecialchars(strip_tags($this->n_questions));
        //$this->questions=htmlspecialchars(strip_tags($this->questions));
        $this->time=htmlspecialchars(strip_tags($this->time));

        $test_db=$this->test_db;

        //It loads the data file and converts it to an array
        $test_data = file_get_contents($test_db);
        $test_json = json_decode($test_data, true);
        if (count($test_json)>0){
            $test_array=$test_json;
        }else{
            $test_array=array();//It creates a new array
        }
        $test_ar = $test_array;//The array with the users already created
        
        //Se inicializa el array con los datos del usuario a crear
        $new_test = array();
        //It saves the user data into the array
        $new_test["test_id"]=$this->test_id;
        $new_test["n_questions"]=$this->n_questions;
        $new_test["questions"]=$this->questions;
        $new_test["time"]=$this->time;
        $test_ar[$this->test_id]=$new_test;
        $fp = fopen($test_db, 'w');
        
        // execute query
        if(fwrite($fp, json_encode($test_ar))){
            return true;
        }else{
            return false;  
        } 
        fclose($fp);        
    }

    // get specific test by test_id
    function get_test(){
        
        $test_db=$this->test_db;
        // query to read single record
        //It loads the data file and converts it to an array
        $test_data = file_get_contents($test_db);
        $test_json = json_decode($test_data, true);
        if (count($test_json)>0){
            $test_found=$test_json[$this->test_id];
        }else{
            $test_found=null;
        }
     
        // set values to object properties
        $this->test_id = $test_found['test_id'];
        $this->questions = $test_found['questions'];
        $this->n_questions = $test_found['n_questions'];
        $this->time = $test_found['time'];
    }
}
?>