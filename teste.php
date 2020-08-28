<?php

$servername = "localhost";
$username = "root";
$password = "123";
$dbname = "devsbook";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$data = date('Y-m-d H:i:s');

$sql = "INSERT INTO posts (id_user, type, created_at, body)
VALUES ($userInfo->id, 'text', '$data', '$body')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

exit;



$conn->close();
?>