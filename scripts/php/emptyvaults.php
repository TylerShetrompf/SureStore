<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

$wh = $_POST["whid"];

$emptyquery = pg_query_params($surestore_db, "SELECT surevault.vaultid from surevault where surevault.vaultwh = $1 and surevault.vaultid not in (select surevault.vaultid from surevault full outer join sureitems on surevault.vaultid = sureitems.itemvault where sureitems.datein is not null and sureitems.dateout is null and sureitems.itemvault is not null)", array($wh));

$result = pg_fetch_all($emptyquery);

echo json_encode($result);

// Close db connection
pg_close($surestore_db);