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
    include_once '../object/taker.php';
    include_once '../object/assesment.php';
    include_once '../object/test.php';
    
    //instantiate objects
    $database = new Database();
    $db = $database->getConnection();
    $taker = new Taker($db);
    $assesment = new Assesment($db);
    // Test object to be searched
    $test_search = new Test($db);
    
    $new_id_session=null;
    
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
            
            // Test ID of test preselected with the assesment (depending on the application?)
            $test_search->test_id = "1";
            // read the details of test to be edited
            $test_search->get_test();

            //Session_id generation
            $new_id_session=create_session_id();

            $assesment->taker=$taker->email;
            $assesment->session_id=$new_id_session;
            $assesment->test=$test_search->test_id;

            // create the taker
            if($assesment->create()){
                // set response code - 201 created
                http_response_code(201);
                // tell the user
                echo json_encode(array("message" => "Assesmente created succesfully."));
            }else{
                echo json_encode(array("message" => "Assesmente was not created."));
            }
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

    date_default_timezone_set('America/Bogota');
    function create_session_id()
    {
        $microTime = microtime();
        list($a_dec, $a_sec) = explode(" ", $microTime);

        $dec_hex = dechex($a_dec* 1000000);
        $sec_hex = dechex($a_sec);

        ensure_length($dec_hex, 5);
        ensure_length($sec_hex, 6);

        $sessid = "";
        $sessid .= $dec_hex;
        $sessid .= create_sessid_section(3);
        $sessid .= '-';
        $sessid .= create_sessid_section(4);
        $sessid .= '-';
        $sessid .= create_sessid_section(4);
        $sessid .= '-';
        $sessid .= create_sessid_section(4);
        $sessid .= '-';
        $sessid .= $sec_hex;
        $sessid .= create_sessid_section(6);

        return $sessid;

    }

    function create_sessid_section($characters)
    {
        $return = "";
        for($i=0; $i<$characters; $i++)
        {
            $return .= dechex(mt_rand(0,15));
        }
        return $return;
    }

    function ensure_length(&$string, $length)
    {
        $strlen = strlen($string);
        if($strlen < $length)
        {
            $string = str_pad($string,$length,"0");
        }
        else if($strlen > $length)
        {
            $string = substr($string, 0, $length);
        }
    }
?>