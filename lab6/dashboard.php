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
<?php
$folder = "uploads/";

if (!is_dir($folder)) {
    mkdir($folder);
}

if (isset($_POST['upload'])) {
    $fileName = $_FILES['myfile']['name'];
    $tmpName = $_FILES['myfile']['tmp_name'];

    if (move_uploaded_file($tmpName, $folder.$fileName)) {
        echo "File uploaded successfully!";
    } else {
        echo "Upload failed!";
    }
}

if (isset($_GET['download'])) {
    $file = $folder.$_GET['download'];

    if (file_exists($file)) {
        header("Content-Disposition: attachment; filename=".basename($file));
        header("Content-Type: application/octet-stream");
        readfile($file);
        exit;
    }
}

if (isset($_GET['delete'])) {
    unlink($folder.$_GET['delete']);
    echo "File deleted!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>File Manager</title>
</head>
<body>

<h2>Upload File</h2>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="myfile" required>
    <button type="submit" name="upload">Upload</button>
</form>

<h2>Uploaded Files</h2>
<table border="1" cellpadding="5">
<tr>
    <th>File</th>
    <th>Size</th>
    <th>Modified</th>
    <th>Actions</th>
</tr>

<?php
$files = scandir($folder);
foreach ($files as $f) {
    if ($f != "." && $f != "..") {
        $path = $folder.$f;
        echo "<tr>";
        echo "<td>$f</td>";
        echo "<td>".filesize($path)." bytes</td>";
        echo "<td>".date("d-m-Y H:i:s", filemtime($path))."</td>";
        echo "<td>
            <a href='?download=$f'>Download</a> | 
            <a href='?delete=$f'>Delete</a>
        </td>";
        echo "</tr>";
    }
}
?>

</table>

<br>
<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>

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


