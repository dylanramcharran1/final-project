<?php
session_start();
// For demo: hardcoded judge credentials
$judges = [
    "judge1" => "pass1",
    "judge2" => "pass2",
    "judge3" => "pass3",
    "judge4" => "pass4"
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    if (!isset($judges[$user]) || $judges[$user] !== $pass) {
        die("Invalid credentials. <a href='index.html'>Try again</a>");
    }
    $_SESSION['judge'] = $user;
} elseif (!isset($_SESSION['judge'])) {
    header("Location: index.html");
    exit();
}
$judge = $_SESSION['judge'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Computer Science Project Rubric</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        table { border-collapse: collapse; width: 80%; margin: 30px auto; background: #fff; }
        th, td { border: 1px solid #aaa; padding: 10px; text-align: center; }
        th { background: #ccc; }
        .criteria { text-align: left; font-weight: bold; }
        .section { background: #ddd; font-weight: bold; }
        .group-info td { background: #ddd; }
        .total-row td { font-weight: bold; }
        textarea { width: 98%; }
        .center { text-align: center; }
        .submit-btn { padding: 10px 30px; background: #333; color: #fff; border: none; margin: 20px; }
    </style>
    <script>
        function onlyOnePerRow(row) {
            var dev = document.getElementById('dev_' + row);
            var acc = document.getElementById('acc_' + row);
            dev.oninput = function() {
                acc.disabled = !!dev.value;
                if (dev.value) acc.value = '';
                else acc.disabled = false;
            };
            acc.oninput = function() {
                dev.disabled = !!acc.value;
                if (acc.value) dev.value = '';
                else dev.disabled = false;
            };
        }
        window.onload = function() {
            for (var i = 1; i <= 4; i++) onlyOnePerRow(i);
        };
    </script>
</head>
<body>
    <form action="submit.php" method="post">
    <table>
        <tr><th colspan="4" class="section">Computer Science Project</th></tr>
        <tr class="group-info">
            <td class="criteria">Group Members:</td>
            <td colspan="3"><input type="text" name="group_members" required></td>
        </tr>
        <tr class="group-info">
            <td class="criteria">Number:</td>
            <td colspan="3"><input type="text" name="group_number" required></td>
        </tr>
        <tr class="group-info">
            <td class="criteria">Project Title:</td>
            <td colspan="3"><input type="text" name="project_title" required></td>
        </tr>
        <tr>
            <th>Criteria</th>
            <th>Developing(0-10)</th>
            <th>Accomplished(11-15)</th>
            <th></th>
        </tr>
        <tr>
            <td class="criteria">Articulate requirements</td>
            <td><input type="number" min="0" max="10" name="dev1" id="dev_1"></td>
            <td><input type="number" min="11" max="15" name="acc1" id="acc_1"></td>
            <td></td>
        </tr>
        <tr>
            <td class="criteria">Choose appropriate tools and methods for each task</td>
            <td><input type="number" min="0" max="10" name="dev2" id="dev_2"></td>
            <td><input type="number" min="11" max="15" name="acc2" id="acc_2"></td>
            <td></td>
        </tr>
        <tr>
            <td class="criteria">Give clear and coherent oral presentation</td>
            <td><input type="number" min="0" max="10" name="dev3" id="dev_3"></td>
            <td><input type="number" min="11" max="15" name="acc3" id="acc_3"></td>
            <td></td>
        </tr>
        <tr>
            <td class="criteria">Functioned well as a team</td>
            <td><input type="number" min="0" max="10" name="dev4" id="dev_4"></td>
            <td><input type="number" min="11" max="15" name="acc4" id="acc_4"></td>
            <td></td>
        </tr>
        <tr class="total-row">
            <td>Total</td>
            <td colspan="3"><input type="text" name="total" id="total" readonly></td>
        </tr>
        <tr>
            <td class="criteria">Judge's name:</td>
            <td colspan="3"><input type="text" name="judge_name" value="<?php echo htmlspecialchars($judge); ?>" readonly></td>
        </tr>
        <tr>
            <td class="criteria">Comments:</td>
            <td colspan="3"><textarea name="comments" rows="3"></textarea></td>
        </tr>
    </table>
    <div class="center">
        <button type="submit" class="submit-btn">Submit</button>
    </div>
    </form>
    <script>
        // Calculate total
        function calcTotal() {
            let total = 0;
            for (let i = 1; i <= 4; i++) {
                let dev = document.getElementById('dev_' + i).value;
                let acc = document.getElementById('acc_' + i).value;
                total += Number(dev) || 0;
                total += Number(acc) || 0;
            }
            document.getElementById('total').value = total;
        }
        for (let i = 1; i <= 4; i++) {
            document.getElementById('dev_' + i).addEventListener('input', calcTotal);
            document.getElementById('acc_' + i).addEventListener('input', calcTotal);
        }
    </script>
</body>
</html>