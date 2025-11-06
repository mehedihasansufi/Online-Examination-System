<?php

$connection = mysqli_connect("localhost", "root", "", "online_examination");
if (mysqli_connect_errno()) {
    echo "not connected" . mysqli_connect_error();
} else {
    $user = $_POST['user'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    if($user=="student"){
        $table="student_table";
        $redirect_page="../Student/student.html";
    }else{
        $table="teacher_table";
        $redirect_page="../admin/admin.html";
    }

    $check_sql = "SELECT * FROM $table WHERE  email='$email' ";
    $check_result = mysqli_query($connection, $check_sql);


    if (mysqli_num_rows($check_result) > 0) {

        echo "user already exit with the same email ";
        exit();
    }

    $sql = "INSERT INTO $table (name,email,password) VALUES ('$name','$email','$password')";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        echo "Sign-up successfully";
        header("Location: $redirect_page");
    } else {
        echo "query error";
    }
}
