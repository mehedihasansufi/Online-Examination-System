<?php
$connection = mysqli_connect("localhost:3307", "root", "", "online_examination");
if(!$connection){ die("DB connection failed: ".mysqli_connect_error()); }

$exam = $_GET['exam_name'] ?? '';
if(!$exam){ echo json_encode([]); exit; }

$sql = "SELECT id, question_text, option1, option2, option3, option4 FROM questions WHERE exam_name=?";
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, "s", $exam);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$questions = [];
while($row = mysqli_fetch_assoc($result)){
    $questions[] = $row;
}

header('Content-Type: application/json');
echo json_encode($questions);
?>
