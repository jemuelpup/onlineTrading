<?php

require $_SERVER['DOCUMENT_ROOT'].'/common/dbconnect.php';
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$process = $request->process;
$data = $request->data;
session_start();
$_SESSION["employeeID"] = 0;
$_SESSION["position"] = 0;
switch($process){
	case "login":{login($conn,$data);}break;
	case "logout":{logout();}break;
}
function logout(){
	$_SESSION["employeeID"] = 0;
	$_SESSION["position"] = 0;
}

function login($c,$d){
	$stmt = $c->prepare('SELECT employee_id_fk,(SELECT position_fk FROM employee_tbl WHERE id = employee_id_fk) as position FROM access_tbl a WHERE username = ? AND password = ? AND active=1');
	$stmt->bind_param('ss', $d->username, $d->password);
	$tempEmployeeId = 0;
	$tempPosition = 0;
	if($stmt->execute()){
		$stmt->store_result();
		$stmt->bind_result($employee_id_fk,$position);
		while ($all = $stmt->fetch()) {
			$_SESSION["employeeID"] = $employee_id_fk;
			$_SESSION["position"] = $position;
	    }
		echo $_SESSION["position"];

	}
	else{
		echo "0";
	}
}

?>