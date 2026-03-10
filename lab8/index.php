<?php
session_start();

/* -------------------------------
   PART A: VARIABLES & DATATYPES
--------------------------------*/
$name = "Supriya";
$age = 20;
$percentage = 89.5;
$isLoggedIn = true;
$skills = array("PHP", "HTML", "CSS");

/* -------------------------------
   PART A: VARIABLE SCOPE
--------------------------------*/
$globalMsg = "This is a global variable";

function localScopeDemo() {
    $localVar = "I am local variable";
    echo "<p>Local Scope: $localVar</p>";
}

function globalScopeDemo() {
    global $globalMsg;
    echo "<p>Global Scope: $globalMsg</p>";
}

function staticScopeDemo() {
    static $count = 0;
    $count++;
    echo "<p>Static Scope Count: $count</p>";
}

/* -------------------------------
   PART B: STRING FUNCTIONS
--------------------------------*/
$rawUsername = "   supriya akula   ";

$cleanUsername = trim($rawUsername);
$upperName = strtoupper($cleanUsername);
$lowerName = strtolower($cleanUsername);
$firstUpper = ucfirst($cleanUsername);
$wordsUpper = ucwords($cleanUsername);
$length = strlen($cleanUsername);
$wordCount = str_word_count($cleanUsername);
$reverse = strrev($cleanUsername);
$pos = strpos($cleanUsername, "akula");
$replaced = str_replace("akula", "A.", $cleanUsername);
$sub = substr($cleanUsername, 0, 7);
$compare = strcmp("admin", "Admin");
$icompare = strcasecmp("admin", "Admin");
$safeString = htmlspecialchars("<script>alert('x')</script>");
$slashString = addslashes("I'm learning PHP");

/* -------------------------------
   VALIDATION (Task C)
--------------------------------*/
if ($length < 3) {
    die("Username too short!");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h2>Welcome to Dashboard</h2>

<h3>Datatypes</h3>
<?php
echo "Name: $name <br>";
print "Age: $age <br>";
echo "Percentage: $percentage <br>";
echo "Logged In: $isLoggedIn <br>";
echo "Skills: ";
print_r($skills);
?>

<h3>Variable Scope</h3>
<?php
localScopeDemo();
globalScopeDemo();
staticScopeDemo();
staticScopeDemo();
?>

<h3>String Functions</h3>
<?php
echo "Original: '$rawUsername' <br>";
echo "Trimmed: $cleanUsername <br>";
echo "Upper: $upperName <br>";
echo "Lower: $lowerName <br>";
echo "Ucfirst: $firstUpper <br>";
echo "Ucwords: $wordsUpper <br>";
echo "Length: $length <br>";
echo "Word Count: $wordCount <br>";
echo "Reverse: $reverse <br>";
echo "Position of 'akula': $pos <br>";
echo "Replace: $replaced <br>";
echo "Substring: $sub <br>";
echo "strcmp: $compare <br>";
echo "strcasecmp: $icompare <br>";
echo "htmlspecialchars: $safeString <br>";
echo "addslashes: $slashString <br>";
?>

<hr>
<a href="file_upload.php">Go to File Upload System</a>

</body>
</html>

