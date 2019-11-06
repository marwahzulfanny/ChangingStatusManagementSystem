<?php
$link = mysqli_connect("localhost", "root", "", "status_mahasiswa"); 

if($link === false){ 
	die("ERROR: Could not connect. " 
				. mysqli_connect_error()); 
} 

$sql = "UPDATE stu_status SET status ='menanti pengecekan' WHERE id=1"; 
if(mysqli_query($link, $sql)){ 
	echo "Record was updated successfully."; 
} else { 
	echo "ERROR: Could not able to execute $sql. " 
							. mysqli_error($link); 
} 
mysqli_close($link); 
?> 
