<?php
class Asses_answer{
 
    // database connection and table name
    private $conn;
    private $table_name = "asses_answer";
    private $assesm_answer_db;
 
    // object properties
    public $session_id;
    public $question;
    public $option_answered;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
        $temp=$db.$this->table_name.".json";
        $this->assesm_answer_db=$temp;
        
        if (!file_exists($temp)) {//If it hasn't been created
            $content = array();
            $fp = fopen($temp, 'w');
            fwrite($fp, json_encode($content));
            fclose($fp);
        }
    }

    // create assesment answer
    function create(){
        
        // sanitize
        $this->question=htmlspecialchars(strip_tags($this->question));
        $this->session_id=htmlspecialchars(strip_tags($this->session_id));
        $this->option_answered=htmlspecialchars(strip_tags($this->option_answered));

        $assesm_answer_db=$this->assesm_answer_db;

        //It loads the data file and converts it to an array
        $assesm_answer_dbta = file_get_contents($assesm_answer_db);
        $assesm_answer_json = json_decode($assesm_answer_dbta, true);
        if (count($assesm_answer_json)>0){
            $assesm_answer_array=$assesm_answer_json;
        }else{
            $assesm_answer_array=array();//It creates a new array
        }
        $assesm_answer_ar = $assesm_answer_array;//The array with the users already created
        
        //Se inicializa el array con los datos del usuario a crear
        $new_assesm = array();
        //It saves the user data into the array
        $new_assesm["question"]=$this->question;
        $new_assesm["session_id"]=$this->session_id;
        $new_assesm["option_answered"]=$this->option_answered;
        $assesm_answer_ar[$this->session_id."-".$this->question]=$new_assesm;
        $fp = fopen($assesm_answer_db, 'w');
        
        // execute query
        if(fwrite($fp, json_encode($assesm_answer_ar))){
            return true;
        }else{
            return false;  
        } 
        fclose($fp);        
    }

}
?>