<?php
// Show all errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$connection = mysqli_connect("localhost:3307", "root", "", "online_examination");

if (!$connection) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Check form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Escape exam name
    $exam_name = mysqli_real_escape_string($connection, $_POST['exam_name']);

    // Get all dynamic question fields as arrays
    $questions = $_POST['question_text'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];
    $correct_option = $_POST['correct_option'];

    // Count total questions
    $count = count($questions);
    $success = 0;

    for ($i = 0; $i < $count; $i++) {
        $q = mysqli_real_escape_string($connection, $questions[$i]);
        $o1 = mysqli_real_escape_string($connection, $option1[$i]);
        $o2 = mysqli_real_escape_string($connection, $option2[$i]);
        $o3 = mysqli_real_escape_string($connection, $option3[$i]);
        $o4 = mysqli_real_escape_string($connection, $option4[$i]);
        $c  = mysqli_real_escape_string($connection, $correct_option[$i]);

        // Check for empty fields (important if JS failed)
        if (empty($q) || empty($o1) || empty($o2) || empty($o3) || empty($o4) || empty($c)) {
            continue; // skip this question
        }

        // Insert query
        $sql = "INSERT INTO questions (exam_name, question_text, option1, option2, option3, option4, correct_option)
                VALUES ('$exam_name', '$q', '$o1', '$o2', '$o3', '$o4', '$c')";

        if (mysqli_query($connection, $sql)) {
            $success++;
        } else {
            echo "<p style='color:red'>Error: " . mysqli_error($connection) . "</p>";
        }
    }

    echo "<p style='text-align:center; color:green;'>$success / $count Questions Added Successfully!</p>";
    
}
?>
