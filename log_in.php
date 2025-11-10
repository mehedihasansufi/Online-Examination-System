<?php
// 1. Database connect
$connection = mysqli_connect("localhost", "root", "", "online_examination");

if (!$connection) {
    die("Database not connected: " . mysqli_connect_error());
}

// 2. Form data
$user = $_POST['user']; // 'student' or 'teacher'
$email = $_POST['email'];
$password = $_POST['password'];

// 3. Decide table and redirect page
if ($user == "student") {
    $table = "student_table";
    $redirect_page = "./Student/student.html";
} else if ($user == "teacher") {
    $table = "teacher_table";
    $redirect_page = "./admin/admin.html";
} else {
    die("Please select user type!");
}

// 4. Check email and password
$sql = "SELECT * FROM $table WHERE email='$email' AND password='$password'";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    // Login successful → redirect
    header("Location: $redirect_page");
    exit();
} else {
    // Login failed
    echo "<h2 style='color:red;'>❌ Email or password is incorrect for $user!</h2>";
}

mysqli_close($connection);
?>
