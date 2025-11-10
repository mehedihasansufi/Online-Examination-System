<?php
$connection = mysqli_connect("localhost", "root", "", "online_examination");

if (mysqli_connect_errno()) {
    die("Database not connected: " . mysqli_connect_error());
}

$user = $_POST['user'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Decide table and redirect page
if($user == "student"){
    $table = "student_table";
    $redirect_page = "../index.html";
} else {
    $table = "teacher_table";
    $redirect_page = "../index.html";
}

// Check if email already exists
$check_sql = "SELECT * FROM $table WHERE email='$email'";
$check_result = mysqli_query($connection, $check_sql);

if(mysqli_num_rows($check_result) > 0){
    echo "User already exists with the same email!";
    exit();
}

// Insert new user
$sql = "INSERT INTO $table (name, email, password) VALUES ('$name', '$email', '$password')";
$result = mysqli_query($connection, $sql);

if($result){
    // Redirect to corresponding page
    header("Location: $redirect_page");
    exit();
} else {
    echo "Query error: " . mysqli_error($connection);
}

mysqli_close($connection);
?>
