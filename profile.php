<?php
require "config.php";
require_login();
$me = (int)$_SESSION['student_id'];
$message = "";

// Save changes when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $stmt = $conn->prepare("UPDATE students SET name=?, college=?, branch=?, year=?, skills_offered=?, skills_wanted=?, bio=? WHERE id=?");
    $stmt->bind_param("sssssssi", $_POST['name'], $_POST['college'], $_POST['branch'], $_POST['year'], $_POST['offered'], $_POST['wanted'], $_POST['bio'], $me);
    $stmt->execute();
    $message = "Profile saved!";
}

// Load the student's current details
$u = $conn->query("SELECT * FROM students WHERE id = $me")->fetch_assoc();
page_top("My Profile");
?>
<div class="box">
  <div class="avatar big" style="background:<?php echo avatar_color($u['id']); ?>"><?php echo strtoupper(substr($u['name'], 0, 1)); ?></div>
  <h2>My profile</h2>
  <?php if (isset($_GET['new']) || $message != "") { echo "<p class='ok'>" . ($message != "" ? $message : "Welcome! Fill in your profile.") . "</p>"; } ?>
  <form method="post">
    <label>Full name</label>
    <input type="text" name="name" value="<?php echo e($u['name']); ?>" required>
    <label>College</label>
    <input type="text" name="college" value="<?php echo e($u['college']); ?>">
    <div class="two">
      <div><label>Branch</label><input type="text" name="branch" value="<?php echo e($u['branch']); ?>"></div>
      <div><label>Year</label><input type="text" name="year" value="<?php echo e($u['year']); ?>"></div>
    </div>
    <label>Skills I can teach</label>
    <input type="text" name="offered" value="<?php echo e($u['skills_offered']); ?>">
    <label>Skills I want to learn</label>
    <input type="text" name="wanted" value="<?php echo e($u['skills_wanted']); ?>">
    <label>About me</label>
    <textarea name="bio" rows="3"><?php echo e($u['bio']); ?></textarea>
    <button class="btn">Save profile</button>
  </form>
</div>
<?php page_bottom(); ?>
