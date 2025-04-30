<?php
$host = "localhost";
$user = "root";
$pass = "Tb2004@*"; // Use your MySQL password
$dbname = "BloodOrgan";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}