<?php
$connection = mysqli_connect("localhost:3307","root","","online_exam") or die("DB Error");
$exam = $_POST['exam'] ?? '';
$score = 0;

// fetch correct answers
$query = "SELECT id, correct_option FROM questions WHERE exam_name='$exam'";
$res = mysqli_query($connection,$query);

while($row = mysqli_fetch_assoc($res)){
    $qid = $row['id'];
    $correct = $row['correct_option'];

    if(isset($_POST["q$qid"])){
        $ans = $_POST["q$qid"];
        if($ans === $correct){
            $score++;
        }
    }
}

echo "Your score: $score";
?>
