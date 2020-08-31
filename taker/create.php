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
    include_once '../object/taker.php';
     
    $database = new Database();
    $db = $database->getConnection();
    //echo "db: ".$db."<br>";
    $taker = new Taker($db);
    
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    
    // make sure data is not empty
    if(
        !empty($data->first_name) &&
        !empty($data->last_name) &&
        !empty($data->email)
    ){
     
        // set taker property values
        $taker->first_name = $data->first_name;
        $taker->last_name = $data->last_name;
        $taker->email = $data->email;
     
        // create the taker
        if($taker->create()){
     
            // set response code - 201 created
            http_response_code(201);
     
            // tell the user
            echo json_encode(array("message" => "Test Taker created succesfully."));
        }else{
     
            // set response code - 503 service unavailable
            http_response_code(503);
     
            // tell the user
            echo json_encode(array("message" => "Test taker was not created."));
        }
    }else{
     
        // set response code - 400 bad request
        http_response_code(400);
     
        // tell the user
        echo json_encode(array("message" => "It is not possible to create the tester. Incomplete data.".$data."----"));
    }
?>