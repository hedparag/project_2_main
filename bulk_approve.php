<?php
include "./include/config.php";

$ids = json_decode($_POST['ids']);
$idList = implode(",", $ids);

$query = "UPDATE employees SET status = 't' WHERE employee_id IN ($idList)";
pg_query($conn, $query);
pg_close($conn);
