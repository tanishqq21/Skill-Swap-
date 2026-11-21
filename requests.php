<?php
require "config.php";
require_login();
$me = (int)$_SESSION['student_id'];

// 1. Requests sent TO me that are waiting
$incoming = $conn->query("SELECT r.id AS rid, s.* FROM requests r JOIN students s ON s.id = r.from_id WHERE r.to_id = $me AND r.status = 'pending'");
// 2. My accepted swap partners
$friends = $conn->query("SELECT s.* FROM requests r JOIN students s ON s.id = IF(r.from_id = $me, r.to_id, r.from_id) WHERE r.status = 'accepted' AND (r.from_id = $me OR r.to_id = $me)");
// 3. Requests I sent that are still waiting
$sent = $conn->query("SELECT s.name FROM requests r JOIN students s ON s.id = r.to_id WHERE r.from_id = $me AND r.status = 'pending'");

page_top("Requests");
?>
<h2>Requests for you</h2>
<div class="cards">
<?php while ($s = $incoming->fetch_assoc()) { ?>
  <div class="student">
    <div class="avatar" style="background:<?php echo avatar_color($s['id']); ?>"><?php echo strtoupper(substr($s['name'], 0, 1)); ?></div>
    <h3><?php echo e($s['name']); ?></h3>
    <p><b>Teaches:</b> <?php show_skills($s['skills_offered'], "teach"); ?></p>
    <form method="post" action="respond.php" class="row">
      <input type="hidden" name="id" value="<?php echo $s['rid']; ?>">
      <button class="btn" name="action" value="accept">Accept</button>
      <button class="btn btn2" name="action" value="decline">Decline</button>
    </form>
  </div>
<?php } ?>
</div>
<?php if ($incoming->num_rows == 0) { echo "<p class='small'>No new requests.</p>"; } ?>

<h2>Your swap partners</h2>
<div class="cards">
<?php while ($s = $friends->fetch_assoc()) { ?>
  <div class="student">
    <div class="avatar" style="background:<?php echo avatar_color($s['id']); ?>"><?php echo strtoupper(substr($s['name'], 0, 1)); ?></div>
    <h3><?php echo e($s['name']); ?></h3>
    <p class="ok">Email: <?php echo e($s['email']); ?></p>
  </div>
<?php } ?>
</div>
<?php if ($friends->num_rows == 0) { echo "<p class='small'>No partners yet. Send some requests!</p>"; } ?>

<h2>Waiting for a reply</h2>
<p>
<?php
while ($s = $sent->fetch_assoc()) { echo "<span class='chip want'>" . e($s['name']) . "</span> "; }
if ($sent->num_rows == 0) { echo "<span class='small'>None</span>"; }
?>
</p>
<?php page_bottom(); ?>
