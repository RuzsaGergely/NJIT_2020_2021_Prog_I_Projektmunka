<?php
$servername = "mariadb";
$username = "admin";
$password = "admin";
$dbname = "database1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$utfstmt = $conn->prepare("SET NAMES 'utf8'");
$utfstmt->execute();