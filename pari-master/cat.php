<?php
$host='localhost';
 $dbusername='root';
 $dbpassword='';
 $dbname='cat';
 
 $conn = mysqli_connect($host,$dbusername,$dbpassword,$dbname);

 if($conn->connect_error)
{
 die('Connection Failed :'.$conn->connect_error);
}

$sql1="CREATE TABLE MyGuests (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if($conn->query($sql1) == TRUE)
{
	echo " Table  is created";
}
else
{
	echo "Error creating table: " . $conn->error;
}

?>
