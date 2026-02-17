<?php
// Initialize variables
$name = "";
$age = "";
$department = "";
$status = "";

// When form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $age = $_POST["age"];
    $department = $_POST["department"];
    $status = $_POST["status"];
}
<? php
$code = $_GET['code'];

$response = file_get_contents("https://github.com/login/oauth/access_token?client_id=".$_ENV['GITHUB_CLIENT_ID']."&client_secret=".$_ENV['GITHUB_CLIENT_SECRET']."&code=$code");

parse_str($response,$data);
echo "GitHub Login Successful";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Smart Care Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Smart Care Dashboard</h1>

<!-- FORM -->
<h3>Add Patient</h3>
<form method="post" action="">
    <label>Patient Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Age:</label><br>
    <input type="number" name="age" required><br><br>

    <label>Department:</label><br>
    <input type="text" name="department" required><br><br>

    <label>Status:</label><br>
    <select name="status">
        <option>Confirmed</option>
        <option>Pending</option>
        <option>Cancelled</option>
    </select><br><br>

    <button type="submit">Add Patient</button>
</form>

<hr>

<!-- TABLE -->
<h3>Patient Appointments</h3>
<table border="1" cellpadding="10">
    <tr>
        <th>Name</th>
        <th>Age</th>
        <th>Department</th>
        <th>Status</th>
    </tr>

    <?php if ($name != "") { ?>
    <tr>
        <td><?php echo $name; ?></td>
        <td><?php echo $age; ?></td>
        <td><?php echo $department; ?></td>
        <td><?php echo $status; ?></td>
    </tr>}
    
?>
</table>

</body>
</html>


