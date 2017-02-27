<?php
require_once('Config.php');
 
// Connect to db
function connect() {
 	$dsn = "mysql:dbname=". DB_NAME . ";host=" . DB_SERVER . ";charset=utf8";
 	$dbh = new PDO($dsn, DB_USER, DB_PASSWD);
    $dbh->query('SET NAMES utf-8');
    return $dbh;
}
 
// Close
function close($dbh) {
	$dbh = null;
}

?>