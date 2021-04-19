<?php
$dns = "mysql:host=localhost;dbname=simple-login";
$user = "root";
$password = "";

$dbh = new PDO($dns,$user,$password);

// if($dbh){
//     echo "Database connection Success";
// }
