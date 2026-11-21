<?php
// seed.php - open this page ONCE to add 8 demo students (password for all: student123)
require "config.php";

$demo = array(
  array("Aarav Mehta", "aarav@demo.com", "VIT Vellore", "CSE", "2nd", "HTML, Guitar", "Python, Photoshop", "Loves music and web design."),
  array("Meera Nair", "meera@demo.com", "Anna University", "IT", "3rd", "Photoshop, Canva", "HTML, Public speaking", "Design club member."),
  array("Rohan Das", "rohan@demo.com", "SRM University", "CSE", "2nd", "Python, Excel", "Guitar, Canva", "Happy to help with coding."),
  array("Sana Khan", "sana@demo.com", "Christ University", "ECE", "1st", "Public speaking, Guitar", "Python, Excel", "Debate team and guitarist."),
  array("Karthik Raja", "karthik@demo.com", "SASTRA University", "CSE", "3rd", "JavaScript, CSS", "Photography, Video editing", "Building small websites."),
  array("Priya Sharma", "priya@demo.com", "Manipal University", "Business", "2nd", "Content writing, Drawing", "JavaScript, Excel", "Writes blogs for the college club."),
  array("Vikram Singh", "vikram@demo.com", "Delhi University", "Commerce", "3rd", "Piano, Excel", "HTML, Chess", "Plays piano at college fests."),
  array("Divya Menon", "divya@demo.com", "Christ University", "Media", "2nd", "Video editing, Photography", "Python, Singing", "Edits reels for the media club.")
);

$hash = password_hash("student123", PASSWORD_DEFAULT);
$added = 0;
foreach ($demo as $d) {
    $stmt = $conn->prepare("INSERT IGNORE INTO students (name, email, password, college, branch, year, skills_offered, skills_wanted, bio) VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssss", $d[0], $d[1], $hash, $d[2], $d[3], $d[4], $d[5], $d[6], $d[7]);
    $stmt->execute();
    $added = $added + $stmt->affected_rows;
}
echo "Done! Added " . $added . " demo students. <a href='index.php'>Go to home page</a>";
