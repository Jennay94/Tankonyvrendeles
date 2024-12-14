<?php

include "db.php";

$last_name = $_POST['last_name'];
$first_name = $_POST['first_name'];

//$user_name = $first_name.$last_name;


$stmt = $conn->prepare("SELECT * FROM users WHERE last_name = ? AND first_name = ?");

$stmt->bind_param("ss", $last_name, $first_name);
$stmt->execute();
$resultSet = $stmt->get_result();
$data = $resultSet->fetch_all(MYSQLI_ASSOC);




echo var_dump($data);


