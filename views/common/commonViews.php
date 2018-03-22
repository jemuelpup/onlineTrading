<?php
/* This file contains the elements for viewing */
//----------------------------------------------------------
// these are the common functions

function selectCategory($c){
	$sql = "SELECT id,name,category_code,description FROM category_tbl WHERE active=1";
	print_r(hasRows($c,$sql) ? json_encode(selectQuery($c,$sql)) : "");
}
function selectProduct($c){
	$sql = "SELECT id,name,description,picture,product_code,category_fk,stock,(SELECT name FROM category_tbl WHERE id=category_fk) as category_name ,price,available FROM product_tbl WHERE active=1";
	print_r(hasRows($c,$sql) ? json_encode(selectQuery($c,$sql)) : "");
}
function selectVat($c){
	$sql = "SELECT name,percentage FROM pricing_config_tbl WHERE id=1";
	print_r(hasRows($c,$sql) ? json_encode(selectQuery($c,$sql)) : "");
}
function selectServiceCharge($c){
	$sql = "SELECT name,percentage FROM pricing_config_tbl WHERE id=2";
	print_r(hasRows($c,$sql) ? json_encode(selectQuery($c,$sql)) : "");
}
function executeOrdersQuery($c,$sql){
	$structuredDataArray = array();
	$iterationStart = true;
	$catArray = array();
	$category = "";
	$res = $c->query($sql);
	if(hasRows($c,$sql)){
		while($row = $res->fetch_assoc()){
			$orderLine = array("productImg"=>$row["productImg"],"order_line_id"=>$row["order_line_id"],"order_id_fk"=>$row['oLine_order_id_fk'],"product_id_fk"=>$row['oLine_product_id_fk'],"name"=>$row['oLine_name'],"code"=>$row['oLine_code'],"quantity"=>$row['oLine_quantity'],"price"=>$row['oLine_price'],"served"=>$row['oLine_served'],"served_items"=>$row['served_items']);

			if($iterationStart){// at first set the category and add the array
				$iterationStart = false;
				$category = $row['order_id'];
				array_push($catArray,$orderLine);
			}
			elseif($category != $row['order_id']){ // if not the same id, push catArray to structuredDataArray and assign new id to the category
				array_push($structuredDataArray,array("orderDetails"=>$orderDetails,"orderLine"=>$catArray));
				$catArray = array();
				array_push($catArray,$orderLine);
				$category = $row['order_id'];
			}
			else{ // if same id, push it to the category
				array_push($catArray,$orderLine);
			}
			$orderDetails = array("id"=>$row['order_id'],"date"=>$row['order_date'],"seat_number"=>$row['order_seat_number'],"cashier_fk"=>$row['order_cashier_fk'],"branch_fk"=>$row['order_branch_fk'],"waiter_fk"=>$row['order_waiter_fk'],"void"=>$row['order_void_fk'],"total_amount"=>$row['order_total_amount'],"customer_name"=>$row['order_customer_name'],"payment"=>$row['order_payment'],"notes"=>$row['order_notes'],"down_payment"=>$row['order_down_payment'],"received_date"=>$row['order_received_date'],"void_reason"=>$row['order_void_reason'],"printed"=>$row['printed'],"discount"=>$row['order_discount'],"discount_percentage"=>$row['discount_percentage'],"vat"=>$row['vat'],"service_charge"=>$row['service_charge'],"cashier_name"=>$row['cashier_name']);
		}
		array_push($structuredDataArray,array("orderDetails"=>$orderDetails,"orderLine"=>$catArray));
	}
	print_r(json_encode($structuredDataArray));
}

//----------------------------------------------------------

// not sure if common function

function selectUnservedOrders($c){
	$sql = "SELECT (SELECT picture FROM product_tbl WHERE id=ol.product_id_fk) as productImg, ol.id as order_line_id, o.id as order_id,o.order_date as order_date,o.seat_number as order_seat_number,o.cashier_fk as order_cashier_fk,(SELECT name FROM employee_tbl WHERE id=o.cashier_fk) as cashier_name,o.branch_fk as order_branch_fk,o.waiter_fk as order_waiter_fk,o.void as order_void_fk,o.total_amount as order_total_amount,o.customer_name as order_customer_name,o.payment as order_payment,o.notes as order_notes,o.down_payment as order_down_payment,o.received_date as order_received_date,o.void_reason as order_void_reason,o.printed,o.discount as order_discount,o.discount_percentage,ol.order_id_fk as oLine_order_id_fk,ol.product_id_fk as oLine_product_id_fk,ol.name as oLine_name,ol.code as oLine_code,ol.quantity as oLine_quantity,ol.price as oLine_price,ol.served as oLine_served, ol.served_items, o.vat, o.service_charge FROM order_tbl o, order_line_tbl ol WHERE
	 o.void=0 AND o.id = ol.order_id_fk AND o.done=0 AND ol.served_items <> ol.quantity order by o.id";
	executeOrdersQuery($c,$sql);
}
function selectOrders($c){
	$sql = "SELECT (SELECT picture FROM product_tbl WHERE id=ol.product_id_fk) as productImg, ol.id as order_line_id, o.id as order_id,o.order_date as order_date,o.seat_number as order_seat_number,o.cashier_fk as order_cashier_fk,(SELECT name FROM employee_tbl WHERE id=o.cashier_fk) as cashier_name,o.branch_fk as order_branch_fk,o.waiter_fk as order_waiter_fk,o.void as order_void_fk,o.total_amount as order_total_amount,o.customer_name as order_customer_name,o.payment as order_payment,o.notes as order_notes,o.down_payment as order_down_payment,o.received_date as order_received_date,o.void_reason as order_void_reason,o.printed,o.discount as order_discount,o.discount_percentage,ol.order_id_fk as oLine_order_id_fk,ol.product_id_fk as oLine_product_id_fk,ol.name as oLine_name,ol.code as oLine_code,ol.quantity as oLine_quantity,ol.price as oLine_price,ol.served as oLine_served, ol.served_items, o.vat, o.service_charge FROM order_tbl o, order_line_tbl ol WHERE
	 o.void=0 AND o.id = ol.order_id_fk AND o.done=0 order by o.id";
	executeOrdersQuery($c,$sql);
}

//----------------------------------------------------------

?>