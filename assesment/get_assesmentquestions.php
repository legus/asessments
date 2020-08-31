<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../object/assesment.php';
include_once '../object/test.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare assesment object
$assesment = new assesment($db);
$test = new test($db);
 
// set ID property of record to read
$assesment->session_id = isset($_GET['session_id']) ? $_GET['session_id'] : die();
 
// read the details of assesment to be edited
$assesment->get_assesment();

if($assesment->session_id!=null){
    

    //query the question from the test
    $test->test_id=$assesment->test;
    $test->get_test();

    // create array
    $assesment_questions = array(
        "session_id" =>  $assesment->session_id,
        "test_id" => $assesment->test,
        "questions" => $test->questions,
    );
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($assesment_questions);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user assesment does not exist
    echo json_encode(array("message" => "assesment No existe."));
}
?>