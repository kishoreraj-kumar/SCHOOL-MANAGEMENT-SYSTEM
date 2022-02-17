<?php
$conn = new mysqli("localhost", "root", "root","school");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>