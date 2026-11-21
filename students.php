<?php
require "config.php";

// What did the user type in the search box? (GET)
$q = isset($_GET['q']) ? trim($_GET['q']) : "";
$like = "%" . $q . "%";
$me = is_logged_in() ? (int)$_SESSION['student_id'] : 0;

$stmt = $conn->prepare("SELECT * FROM students WHERE id <> ? AND (name LIKE ? OR skills_offered LIKE ? OR skills_wanted LIKE ? OR college LIKE ?) ORDER BY id DESC");
$stmt->bind_param("issss", $me, $like, $like, $like, $like);
$stmt->execute();
$result = $stmt->get_result();

page_top("Students");
?>
<h2>Find students</h2>
<form method="get" class="search">
  <input type="text" name="q" value="<?php echo e($q); ?>" placeholder="Search a skill, name or college">
  <button class="btn">Search</button>
</form>
<p class="small">Quick filter (no reload): <input type="text" id="liveSearch" onkeyup="filterCards()" placeholder="type here"></p>

<div class="cards">
<?php while ($s = $result->fetch_assoc()) { ?>
  <div class="student">
    <div class="avatar" style="background:<?php echo avatar_color($s['id']); ?>"><?php echo strtoupper(substr($s['name'], 0, 1)); ?></div>
    <h3><?php echo e($s['name']); ?></h3>
    <p class="small"><?php echo e($s['branch'] . " " . $s['year'] . " year, " . $s['college']); ?></p>
    <p><?php echo e($s['bio']); ?></p>
    <p><b>Teaches:</b> <?php show_skills($s['skills_offered'], "teach"); ?></p>
    <p><b>Wants:</b> <?php show_skills($s['skills_wanted'], "want"); ?></p>

    <?php
    if ($me == 0) {
        echo "<a class='btn' href='login.php'>Login to connect</a>";
    } else {
        $r = request_between($conn, $me, $s['id']);
        if (!$r) { ?>
            <form method="post" action="send_request.php">
              <input type="hidden" name="to_id" value="<?php echo $s['id']; ?>">
              <button class="btn">Send swap request</button>
            </form>
        <?php } elseif ($r['status'] == "accepted") {
            echo "<p class='ok'>Connected! Email: " . e($s['email']) . "</p>";
        } elseif ($r['status'] == "pending") {
            echo "<p class='note'>Request pending</p>";
        } else {
            echo "<p class='note'>Request declined</p>";
        }
    }
    ?>
  </div>
<?php } ?>
</div>
<?php if ($result->num_rows == 0) { echo "<p>No students found.</p>"; } ?>
<?php page_bottom(); ?>
