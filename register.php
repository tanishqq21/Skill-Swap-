<?php
require "config.php";
$error = "";

// This runs only when the form is submitted (POST)
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if ($name == "" || $email == "" || $password == "") {
        $error = "Please fill name, email and password.";
    } elseif (strlen($password) < 6) {
        $error = "Password must have at least 6 characters.";
    } elseif ($password != $confirm) {
        $error = "Passwords do not match.";
    } else {
        // Is this email already used?
        $stmt = $conn->prepare("SELECT id FROM students WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "This email is already registered. Please login.";
        } else {
            // Save the new student. The password is stored in scrambled (hashed) form.
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO students (name, email, password, college, branch, year, skills_offered, skills_wanted, bio) VALUES (?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssssss", $name, $email, $hash, $_POST['college'], $_POST['branch'], $_POST['year'], $_POST['offered'], $_POST['wanted'], $_POST['bio']);
            $stmt->execute();

            $_SESSION['student_id'] = $conn->insert_id;   // log the student in
            header("Location: profile.php?new=1");
            exit;
        }
    }
}

page_top("Register");
?>
<div class="box">
  <h2>Create your account</h2>
  <?php if ($error != "") { echo "<p class='error'>" . e($error) . "</p>"; } ?>

  <form method="post" onsubmit="return checkRegister()">
    <label>Full name</label>
    <input type="text" name="name" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" id="password" required>
    <label>Confirm password</label>
    <input type="password" name="confirm" id="confirm" required>
    <p class="small"><a href="#" onclick="togglePassword('password'); togglePassword('confirm'); return false;">Show / hide password</a></p>

    <label>College</label>
    <input type="text" name="college">

    <div class="two">
      <div><label>Branch</label><input type="text" name="branch" placeholder="CSE"></div>
      <div><label>Year</label>
        <select name="year"><option>1st</option><option>2nd</option><option>3rd</option><option>4th</option></select>
      </div>
    </div>

    <label>Skills you can teach (separate with commas)</label>
    <input type="text" name="offered" placeholder="HTML, Guitar">
    <label>Skills you want to learn</label>
    <input type="text" name="wanted" placeholder="Python, Public speaking">
    <label>About you</label>
    <textarea name="bio" rows="3"></textarea>

    <button class="btn">Register</button>
  </form>
  <p class="small">Already have an account? <a href="login.php">Login</a></p>
</div>
<?php page_bottom(); ?>
