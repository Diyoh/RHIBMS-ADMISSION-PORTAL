<?php
$mysqli = new mysqli("localhost", "root", "");
if ($mysqli->connect_error) { 
    die("Connection failed: " . $mysqli->connect_error); 
}
$mysqli->query("CREATE DATABASE IF NOT EXISTS admission_system_test");
$mysqli->close();
echo "Test database created successfully.\n";
