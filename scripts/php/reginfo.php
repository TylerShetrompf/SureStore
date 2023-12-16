<?php

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Initialize data array
$data = [];

$orderid = $_POST["orderid"];

$reginfoquery = pg_query_params($surestore_db, "select sureorders.orderid, sureorders.orderwh, sureorders.ordermil, sureorders.datein, sureorders.dateout, sureorders.weight, surecustomer.* from sureorders left join surecustomer on surecustomer.custid = sureorders.ordercust and sureorders.orderid=$1", array($orderid));

$reginforesults = pg_fetch_assoc($reginfoquery);

echo json_encode($reginforesults);