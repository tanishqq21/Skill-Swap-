// script.js - small JavaScript used on the pages

// 1. Check the register form before it is sent to PHP
function checkRegister() {
  var pass = document.getElementById("password").value;
  var confirm = document.getElementById("confirm").value;
  if (pass.length < 6) {
    alert("Password must have at least 6 characters");
    return false;       // false = stop the form from being sent
  }
  if (pass != confirm) {
    alert("Passwords do not match");
    return false;
  }
  return true;
}

// 2. Show or hide a password box
function togglePassword(id) {
  var box = document.getElementById(id);
  if (box.type == "password") {
    box.type = "text";
  } else {
    box.type = "password";
  }
}

// 3. Live filter on the students page (hides cards that do not match what you type)
function filterCards() {
  var text = document.getElementById("liveSearch").value.toLowerCase();
  var cards = document.getElementsByClassName("student");
  for (var i = 0; i < cards.length; i++) {
    var cardText = cards[i].innerText.toLowerCase();
    if (cardText.indexOf(text) > -1) {
      cards[i].style.display = "block";
    } else {
      cards[i].style.display = "none";
    }
  }
}
