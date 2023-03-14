<?php
$servername = "localhost";
$username = "root";
$password = "";
//dùng PDO trên w3school
try {
  $conn = new PDO("mysql:host=$servername;dbname=tracnghiem", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "";
} catch(PDOException $e) {
  echo "" . $e->getMessage();
}
?>