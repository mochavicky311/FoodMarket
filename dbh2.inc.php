<?php

$dbServername = "foodmarket-mariadb.mariadb.database.azure.com";
$dbUsername = "foodmarketadmin@foodmarket-mariadb";
$dbPassword = "Admin@foodmarket123";
$dbName = "foodmarket";
$dbPort = 3306;

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName, $dbPort);