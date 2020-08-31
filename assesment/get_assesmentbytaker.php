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
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare assesment object
$assesment = new assesment($db);
 
// set ID property of record to read
$assesment->taker = isset($_GET['taker']) ? $_GET['taker'] : die();
 
// read the details of assesment to be edited
$assesment->get_assesment_by_taker();

if($assesment->session_id!=null){
    
    // create array
    $assesment = array(
        "session_id" =>  $assesment->session_id,
        "test_id" => $assesment->test,
        "taker" => $assesment->taker
    );
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($assesment);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user assesment does not exist
    echo json_encode(array("message" => "assesment does not exist."));
}
?>