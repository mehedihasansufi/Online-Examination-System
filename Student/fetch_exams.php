<?php
$connection = mysqli_connect("localhost:3307", "root", "", "online_examination");

if (!$connection) {
    die(json_encode(["error" => "Database connection failed."]));
}

// ✅ DISTINCT ব্যবহার করলে একই exam_name একবারই আসবে
$query = "SELECT DISTINCT exam_name FROM questions ORDER BY id DESC";
$result = mysqli_query($connection, $query);

$exams = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $exams[] = $row;
    }
}

echo json_encode($exams);
mysqli_close($connection);
?>
