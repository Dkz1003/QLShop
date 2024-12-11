<?php 
$servername="localhost:3307";
$username="root";
$password="";
$database="qlda";
$conn = new mysqli($servername,$username,$password,$database);
if ($conn->connect_error){
	die("Lỗi kết nối với CSDL");
}
?>