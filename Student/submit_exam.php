<?php
session_start(); // session start

$connection = mysqli_connect("localhost:3307", "root", "", "online_examination");
if(!$connection){
    die("DB connection failed: ".mysqli_connect_error());
}

// 1. Check if user is logged in
if(!isset($_SESSION['user_name'])){
    echo "User not logged in!";
    exit;
}
$user_name = $_SESSION['user_name'];

// 2. Check exam name
$exam = $_POST['exam'] ?? '';
if(!$exam){
    echo "Exam name missing";
    exit;
}

// 3. Check if user already submitted this exam
$check_sql = "SELECT * FROM result_table WHERE name=? AND exam_name=?";
$check_stmt = mysqli_prepare($connection, $check_sql);
mysqli_stmt_bind_param($check_stmt, "ss", $user_name, $exam);
mysqli_stmt_execute($check_stmt);
$check_result = mysqli_stmt_get_result($check_stmt);

if(mysqli_num_rows($check_result) > 0){
    echo "You have already submitted this exam!";
    exit;
}

// 4. Fetch questions with correct_option
$sql = "SELECT id, option1, option2, option3, option4, correct_option FROM questions WHERE exam_name=?";
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, "s", $exam);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$questions = [];
while($row = mysqli_fetch_assoc($result)){
    $questions[$row['id']] = $row; // store all options + correct_option
}

// 5. Calculate score
$score = 0;
foreach($_POST as $key => $value){
    if(str_starts_with($key, 'q')){
        $q_id = str_replace('q','',$key);
        $user_ans = trim($value);

        if(isset($questions[$q_id])){
            $correct_col = $questions[$q_id]['correct_option']; // e.g., option3
            $correct_ans = $questions[$q_id][$correct_col];     // get actual text
            if(strcasecmp($user_ans, $correct_ans) === 0){     // case-insensitive match
                $score++;
            }
        }
    }
}

// 6. Insert result into result_table
$insert_sql = "INSERT INTO result_table (name, exam_name, markes) VALUES (?, ?, ?)";
$insert_stmt = mysqli_prepare($connection, $insert_sql);
mysqli_stmt_bind_param($insert_stmt, "ssi", $user_name, $exam, $score);
mysqli_stmt_execute($insert_stmt);

// 7. Return score
echo "Your score: $score / ".count($questions);
?>
