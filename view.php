 <?php
$servername = "localhost";
$username = "k4547023";
$password = "admin";
$dbname = "k4547023_jemurin";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
$sql ="select status from status";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        if($row['status']==0)echo "<h1>Hujan</h1>";
        else if($row['status']==1)echo "<h1>Terang</h1>";
        else echo "<h1>Selesai</h1>";
    }
} else {
    echo "0 results";
}

$page = $_SERVER['PHP_SELF'];
$sec = "4";

?>
<head>
<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">

	<title>Hujan</title>
</head>
<body style="background-color:#89C4F4;width:350px;margin: auto">
	<img src="assets/rain.png"align="middle"></img>
	<h1></h1>
</body>
