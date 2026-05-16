<?php
session_start();

if (!isset($_SESSION['judge'])) {
    header("Location: index.html");
    exit();
}

$databaseUrl = getenv("DATABASE_URL");

try {
    $db = parse_url($databaseUrl);

    $host = $db["host"];
    $port = $db["port"] ?? 5432;
    $dbname = ltrim($db["path"], "/");
    $user = $db["user"];
    $pass = $db["pass"];

    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require",
        $user,
        $pass
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS grades (
            id SERIAL PRIMARY KEY,
            judge VARCHAR(50),
            group_members TEXT,
            group_number VARCHAR(50),
            project_title TEXT,
            dev1 VARCHAR(10),
            acc1 VARCHAR(10),
            dev2 VARCHAR(10),
            acc2 VARCHAR(10),
            dev3 VARCHAR(10),
            acc3 VARCHAR(10),
            dev4 VARCHAR(10),
            acc4 VARCHAR(10),
            total INT,
            comments TEXT,
            submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    $stmt = $pdo->prepare("
        INSERT INTO grades (
            judge, group_members, group_number, project_title,
            dev1, acc1, dev2, acc2, dev3, acc3, dev4, acc4,
            total, comments
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $_SESSION['judge'],
        $_POST['group_members'] ?? '',
        $_POST['group_number'] ?? '',
        $_POST['project_title'] ?? '',
        $_POST['dev1'] ?? '',
        $_POST['acc1'] ?? '',
        $_POST['dev2'] ?? '',
        $_POST['acc2'] ?? '',
        $_POST['dev3'] ?? '',
        $_POST['acc3'] ?? '',
        $_POST['dev4'] ?? '',
        $_POST['acc4'] ?? '',
        intval($_POST['total'] ?? 0),
        $_POST['comments'] ?? ''
    ]);

    echo "Submission successful! <a href='rubric.php'>Grade another</a>";

} catch (Exception $e) {
    echo "Database error: " . $e->getMessage();
}
?>
