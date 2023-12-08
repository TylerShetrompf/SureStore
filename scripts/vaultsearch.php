<?php
// Include db connection
include '/var/www/html/scripts/connectdb.php';

// Get user input from post, append %
$userinput = $_POST['query']."%";

// Query
$dbquery = pg_query_params($surestore_db, "select surecustomer.custfirst, surecustomer.custlast, sureorders.orderid, sureitems.itemvault from sureorders inner join surecustomer on sureorders.ordercust=surecustomer.custid inner join sureitems on sureorders.orderid=sureitems.itemorder WHERE sureorders.orderid like $1 OR surecustomer.custfirst like $1 OR surecustomer.custlast like $1 OR sureorders.orderid like $1", array($userinput));

// Save result to associative array
$dbresult = pg_fetch_assoc($dbquery);

// Echo results
echo json_encode($dbresult);

// Close DB connection
pg_close($surestore_db);