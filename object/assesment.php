<?php
class Assesment{
 
    // database connection and table name
    private $conn;
    private $table_name = "assesments";
    private $assesm_db;
 
    // object properties
    public $taker;
    public $session_id;
    public $test;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
        $temp=$db.$this->table_name.".json";
        $this->assesm_db=$temp;
        
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
        $this->taker=htmlspecialchars(strip_tags($this->taker));
        $this->session_id=htmlspecialchars(strip_tags($this->session_id));
        $this->test=htmlspecialchars(strip_tags($this->test));

        $assesm_db=$this->assesm_db;

        //It loads the data file and converts it to an array
        $assesm_dbta = file_get_contents($assesm_db);
        $assesm_json = json_decode($assesm_dbta, true);
        if (count($assesm_json)>0){
            $assesm_array=$assesm_json;
        }else{
            $assesm_array=array();//It creates a new array
        }
        $assesm_ar = $assesm_array;//The array with the users already created
        
        //Se inicializa el array con los datos del usuario a crear
        $new_assesm = array();
        //It saves the user data into the array
        $new_assesm["taker"]=$this->taker;
        $new_assesm["session_id"]=$this->session_id;
        $new_assesm["test"]=$this->test;
        $assesm_ar[$this->session_id]=$new_assesm;
        $fp = fopen($assesm_db, 'w');
        
        // execute query
        if(fwrite($fp, json_encode($assesm_ar))){
            return true;
        }else{
            return false;  
        } 
        fclose($fp);        
    }

    // get specific assesment by session_id
    function get_assesment(){
        
        $assesm_db=$this->assesm_db;
        // query to read single record
        //It loads the data file and converts it to an array
        $assesm_data = file_get_contents($assesm_db);
        $assesm_json = json_decode($assesm_data, true);
        if (count($assesm_json)>0){
            $assesm_found=$assesm_json[$this->session_id];
        }else{
            $assesm_found=null;
        }
     
        // set values to object properties
        $this->session_id = $assesm_found['session_id'];
        $this->test = $assesm_found['test'];
        $this->taker = $assesm_found['taker'];
    }

    // get specific assesment by taker
    function get_assesment_by_taker(){
        
        $assesm_db=$this->assesm_db;
        // query to read single record
        //It loads the data file and converts it to an array
        $assesm_data = file_get_contents($assesm_db);
        $assesm_json = json_decode($assesm_data, true);
        $assesm_found=null;
        if (count($assesm_json)>0){
            $taker=$this->taker;
            foreach ($assesm_json as $as_key => $as_value) {
                $assesment_id=$as_key;
                foreach ($as_value as $as_var => $as_dat) {
                    if ($as_var=="taker" && $as_dat==$taker) {
                        $assesm_found=$assesm_json[$assesment_id];
                    }   
                }
            }
        }
     
        // set values to object properties
        $this->session_id = $assesm_found['session_id'];
        $this->test = $assesm_found['test'];
        $this->taker = $assesm_found['taker'];
    }
}
?>