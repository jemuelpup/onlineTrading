<?php
/* This file contains the elements for viewing */

require $_SERVER['DOCUMENT_ROOT'].'/common/dbconnect.php';
include $_SERVER['DOCUMENT_ROOT'].'/common/commonfunctions.php';
require $_SERVER['DOCUMENT_ROOT'].'/views/common/commonViews.php';
session_start();
$process="";

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$process = $request->process;
$data = $request->data;

// $process = "GetCategory";
switch($process){
	case "GetOrders":{selectOrders($conn);}break;
	case "GetCategory":{selectCategory($conn);}break;
	case "GetProduct":{selectProduct($conn);}break;
	case "GetUnservedOrders":{selectUnservedOrders($conn);}break;
	case "GetEmployeeAccess":{echo $_SESSION["position"];}break;
	case "GetVAT":{selectVat($conn);}break;
	case "GetServiceCharge":{selectServiceCharge($conn);}break;
}
// selectEmployee($conn);


?>