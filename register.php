<?php 
if(isset($_GET['register'])) {
  file_put_contents('logs.txt', $_GET['register'].PHP_EOL , FILE_APPEND | LOCK_EX);
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register Page</title>
	<script>
function ajax_get(url, callback) {
  var xhr = new XMLHttpRequest()
      xhr.open("GET", url, true)
      xhr.send()
      xhr.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200)
              callback(this.responseText)
      }
}

function register() {
  let n = document.getElementById('nameA'),
      e = document.getElementById('emailA')
  ajax_get('/register.php?register=' + n.value + ":" + e.value, function(response) {
    document.getElementById('registerPage').innerHTML = "<font color=green size=26px>Registration Successful</font>"
  })
}
	</script>
</head>
<body> 
  <div id='registerPage'>
    <input placeholder="Your Name" id='nameA'>
    <br>
    <input placeholder="Email Address" id='emailA'>
    <br>
    <button onclick="register()">Register</button>
  </div>
</body>
</html>
