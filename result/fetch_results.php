<?php
session_start();
$connection = mysqli_connect("localhost:3307", "root", "", "online_examination");
if(!$connection){
    die("DB connection failed: ".mysqli_connect_error());
}

// Check if student is logged in
if(!isset($_SESSION['user_name'])){
    echo json_encode([]);
    exit;
}

$user_name = $_SESSION['user_name'];

// Fetch results for this student
$sql = "SELECT exam_name, markes FROM result_table WHERE name=?";
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, "s", $user_name);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$results = [];
while($row = mysqli_fetch_assoc($result)){
    $results[] = $row;
}

header('Content-Type: application/json');
echo json_encode($results);
?>
