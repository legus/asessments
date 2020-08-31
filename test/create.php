<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
     
    // get database connection
    include_once '../config/database.php';
     
    // instantiate sujeto object
    include_once '../object/test.php';
     
    $database = new Database();
    $db = $database->getConnection();
    //echo "db: ".$db."<br>";
    $test = new Test($db);
    
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    
    // make sure data is not empty
    if(
        !empty($data->test_id) &&
        !empty($data->n_questions) &&
        !empty($data->questions) &&
        !empty($data->time)
    ){
        //rebuilding questions and options to allow html characters
        $questions=array();
        foreach ($data->questions as $q_id => $q_data) {
            $question=array();
            $question_id=$q_id;
            foreach ($q_data as $q_key => $q_value) {
                if ($q_key=="text") {
                    $question[$q_key]=json_encode($q_value);
                }else if($q_key=="options"){
                    $options=array();
                    foreach ($q_value as $o_id => $o_data) {
                        $option=array();
                        $option_id=$o_id;
                        foreach ($o_data as $o_key => $o_value) {
                            if ($o_key=="text") {
                                $option[$o_key]=json_encode($o_value);
                            }else{
                                $option[$o_key]=$o_value;
                            }
                        }
                        $options[$option_id]=$option;
                    }
                    $question[$q_key]=$options;
                }else{
                    $question[$q_key]=$q_value;
                }
            }

            $questions[$question_id]=$question;
        }
        
        // set test property values
        $test->test_id = $data->test_id;
        $test->n_questions = $data->n_questions;
        $test->questions = $questions;
        $test->time = $data->time;
     
        // create the test
        if($test->create()){
     
            // set response code - 201 created
            http_response_code(201);
     
            // tell the user
            echo json_encode(array("message" => "Test created succesfully."));
        }else{
     
            // set response code - 503 service unavailable
            http_response_code(503);
     
            // tell the user
            echo json_encode(array("message" => "Test was not created."));
        }
    }else{
     
        // set response code - 400 bad request
        http_response_code(400);
     
        // tell the user
        echo json_encode(array("message" => "It is not possible to create the Test. Incomplete data.".$data."----"));
    }
?>