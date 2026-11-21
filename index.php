<?php
require "config.php";

// Count students and accepted swaps for the home page
$row = $conn->query("SELECT COUNT(*) AS total FROM students")->fetch_assoc();
$students = $row['total'];
$row = $conn->query("SELECT COUNT(*) AS total FROM requests WHERE status='accepted'")->fetch_assoc();
$swaps = $row['total'];

page_top("Home");
?>
<section class="hero">
  <h1>Teach what you know.<br>Learn what you love.</h1>
  <p>SkillSwap helps college students find each other and swap skills.</p>
  <a class="btn" href="register.php">Join SkillSwap</a>
  <a class="btn btn2" href="students.php">See students</a>
</section>

<section class="numbers">
  <div><b><?php echo $students; ?></b><br>students</div>
  <div><b><?php echo $swaps; ?></b><br>swaps made</div>
</section>

<h2>How it works</h2>
<section class="steps">
  <div class="step s1"><h3>1. Make a profile</h3><p>Write the skills you can teach and the ones you want to learn.</p></div>
  <div class="step s2"><h3>2. Find a student</h3><p>Search by skill, name or college and send a request.</p></div>
  <div class="step s3"><h3>3. Swap skills</h3><p>When they accept, you can contact each other and start learning.</p></div>
</section>
<?php page_bottom(); ?>
