<?php
// config.php - included at the top of every page.
// It connects to MySQL (mysqli, like the PHP module) and has small helper functions.

session_start();   // lets us remember who is logged in

$conn = new mysqli("localhost", "root", "", "skillswap_lite");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// Is a student logged in?
function is_logged_in() {
    return isset($_SESSION['student_id']);
}

// If nobody is logged in, send them to the login page
function require_login() {
    if (!is_logged_in()) {
        header("Location: login.php");
        exit;
    }
}

// Print text safely (stops people from typing HTML or scripts into the page)
function e($text) {
    return htmlspecialchars($text);
}

// Colour of the round letter avatar. Uses an array and the % (remainder) operator.
function avatar_color($id) {
    $colors = array("#7c4dff", "#ff6f61", "#00b894", "#e6a800", "#0984e3", "#e84393");
    return $colors[$id % count($colors)];
}

// Show skills like "Python, Java" as small coloured chips
function show_skills($text, $class) {
    $list = explode(",", $text);
    foreach ($list as $skill) {
        $skill = trim($skill);
        if ($skill != "") {
            echo "<span class='chip " . $class . "'>" . e($skill) . "</span>";
        }
    }
}

// Find the request (if any) between two students
function request_between($conn, $a, $b) {
    $a = (int)$a;
    $b = (int)$b;
    $result = $conn->query("SELECT * FROM requests WHERE (from_id=$a AND to_id=$b) OR (from_id=$b AND to_id=$a)");
    return $result->fetch_assoc();
}

// Top of every page: <head> and the menu
function page_top($title) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo e($title); ?> - SkillSwap</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <div class="bar">
    <a class="logo" href="index.php">Skill<span>Swap</span></a>
    <nav>
      <a href="index.php">Home</a>
      <a href="students.php">Students</a>
      <?php if (is_logged_in()) { ?>
        <a href="requests.php">Requests</a>
        <a href="profile.php">My Profile</a>
        <a href="logout.php">Logout</a>
      <?php } else { ?>
        <a href="login.php">Login</a>
        <a class="join" href="register.php">Register</a>
      <?php } ?>
    </nav>
  </div>
</header>
<main>
<?php
}

// Bottom of every page
function page_bottom() {
?>
</main>
<footer>SkillSwap - made by students, for students</footer>
<script src="script.js"></script>
</body>
</html>
<?php
}
?>
