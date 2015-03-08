<?php
$servername = "localhost";
$username = "k4547023";
$password = "9N6j6g4Uwq";
$dbname = "k4547023_jemurin";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
$sql ="update satutable set nomor=1 where nomor!=1";
//$result = mysqli_query($conn, $sql);
if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
//header("Location: view.php");
//die();
?>