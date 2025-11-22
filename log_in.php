<?php
session_start(); // শুরুতেই session start করতে হবে

// 1. Database connect
$connection = mysqli_connect("localhost:3307", "root", "", "online_examination");
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
$sql = "SELECT * FROM $table WHERE email=? AND password=?";
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, "ss", $email, $password);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    // Login successful → set session variables
    $_SESSION['user_type'] = $user;
    $_SESSION['user_name'] = $row['name'] ?? $row['email']; // name না থাকলে email রাখবে
    $_SESSION['user_email'] = $row['email'];

    // Redirect to dashboard
    header("Location: $redirect_page");
    exit();
} else {
    // Login failed
    echo "<h2 style='color:red;'>❌ Email or password is incorrect for $user!</h2>";
}

mysqli_close($connection);
?>
