<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../object/test.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare test object
$test = new Test($db);
 
// set ID property of record to read
$test->test_id = isset($_GET['test_id']) ? $_GET['test_id'] : die();
 
// read the details of test to be edited
$test->get_test();

if($test->test_id!=null){
    // create array
    $test_arr = array(
        "test_id" =>  $test->test_id,
        "questions" => $test->questions,
        "time" => $test->time 
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($test_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user test does not exist
    echo json_encode(array("message" => "test No existe."));
}
?>