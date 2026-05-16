<?php
session_start();
if (!isset($_SESSION['judge'])) {
    header("Location: index.html");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // For demo, save to a file. In production, save to a database.
    $data = [
        'judge' => $_SESSION['judge'],
        'group_members' => $_POST['group_members'],
        'group_number' => $_POST['group_number'],
        'project_title' => $_POST['project_title'],
        'dev1' => $_POST['dev1'],
        'acc1' => $_POST['acc1'],
        'dev2' => $_POST['dev2'],
        'acc2' => $_POST['acc2'],
        'dev3' => $_POST['dev3'],
        'acc3' => $_POST['acc3'],
        'dev4' => $_POST['dev4'],
        'acc4' => $_POST['acc4'],
        'total' => $_POST['total'],
        'comments' => $_POST['comments']
    ];
    $line = implode("\t", $data) . "\n";
    file_put_contents("grades.txt", $line, FILE_APPEND);
    echo "Submission successful! <a href='rubric.php'>Grade another</a>";
} else {
    header("Location: rubric.php");
}
?>