<?php
class Taker{
 
    // database connection and table name
    private $conn;
    private $table_name = "takers";
    private $takers_db;
 
    // object properties
    public $first_name;
    public $last_name;
    public $email;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
        $temp=$db.$this->table_name.".json";
        $this->takers_db=$temp;
        
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
        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->email=htmlspecialchars(strip_tags($this->email));

        $takers_db=$this->takers_db;

        //It loads the data file and converts it to an array
        $takers_data = file_get_contents($takers_db);
        $takers_json = json_decode($takers_data, true);
        if (count($takers_json)>0){
            $takers_array=$takers_json;
        }else{
            $takers_array=array();//It creates a new array
        }
        $takers_ar = $takers_array;//The array with the users already created
        
        //Se inicializa el array con los datos del usuario a crear
        $new_taker = array();
        //It saves the user data into the array
        $new_taker["first_name"]=$this->first_name;
        $new_taker["last_name"]=$this->last_name;
        $new_taker["email"]=$this->email;
        $takers_ar[$this->email]=$new_taker;
        $fp = fopen($takers_db, 'w');
        
        // execute query
        if(fwrite($fp, json_encode($takers_ar))){
            return true;
        }else{
            return false;  
        } 
        fclose($fp);        
    }

}
?>