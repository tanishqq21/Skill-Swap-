<?php
require "config.php";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Find the student with this email
    $stmt = $conn->prepare("SELECT id, password FROM students WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // password_verify checks the typed password against the scrambled one
    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['student_id'] = $row['id'];
        header("Location: students.php");
        exit;
    } else {
        $error = "Wrong email or password.";
    }
}

page_top("Login");
?>
<div class="box">
  <h2>Welcome back</h2>
  <?php if ($error != "") { echo "<p class='error'>" . e($error) . "</p>"; } ?>
  <form method="post">
    <label>Email</label>
    <input type="email" name="email" required>
    <label>Password</label>
    <input type="password" name="password" required>
    <button class="btn">Login</button>
  </form>
  <p class="small">New here? <a href="register.php">Create an account</a></p>
</div>
<?php page_bottom(); ?>
