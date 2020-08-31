<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
     
    // get database connection
    include_once '../config/database.php';
     
    // objects clases
    include_once '../object/assesment.php';
    include_once '../object/asses_answer.php';
    
    //instantiate objects
    $database = new Database();
    $db = $database->getConnection();
    $asses_answer = new Asses_answer($db);
    
    $new_id_session=null;
    
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    
    // make sure data is not empty
    if(
        !empty($data->session_id) &&
        !empty($data->question) &&
        !empty($data->option_answered) 
    ){
     
        // set asses_answer property values
        $asses_answer->session_id = $data->session_id;
        $asses_answer->question = $data->question;
        $asses_answer->option_answered = $data->option_answered;
     
        // create the asses_answer
        if($asses_answer->create()){        
            // set response code - 201 created
            http_response_code(201);
            // tell the user
            echo json_encode(array("message" => "Assesmente created succesfully."));
        }else{
     
            // set response code - 503 service unavailable
            http_response_code(503);
            // tell the user
            echo json_encode(array("message" => "Assesmente was not created."));
        }
    }else{
     
        // set response code - 400 bad request
        http_response_code(400);
        // tell the user
        echo json_encode(array("message" => "It is not possible to create the assesment. Incomplete data."));
    }
?>