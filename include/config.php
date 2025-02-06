<?php
$host = "localhost";
$dbname = "user_auth";
$user = "postgres";
$password = "root";

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("connection failed!" . pg_last_error());
}
