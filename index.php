<?php
//requirements!
//make a file called messages.json and add [] inside it.
//Give messages.json 777 permissions

error_reporting( E_ALL );
if(isset($_GET['newMessages'])) {
    header('Content-Type: application/json'); //responds to the request with json format
    $messages_file = json_decode(file_get_contents("messages.json"), true);
    if((int)$_GET['newMessages'] >= count($messages_file))
        echo json_encode([]); //no new messages
    else
        echo json_encode(array_slice($messages_file, $_GET['newMessages']));    //new messages
    exit();
}

if(isset($_GET['addMessage'])) {
    $messages = json_decode(file_get_contents("messages.json"), true);
    $messages [] = $_GET['addMessage'];
    file_put_contents('messages.json', json_encode($messages));
    // echo json_encode($messages);   
    echo "Message Sent";
    exit();
}
?>
<style>
body {margin:0; padding:0; background:lightblue; }
#messages { background:#FFE4B5; width:100%; height:80vh; overflow-y:scroll; }
</style>
<script>

let messagesCount = 0

function ajax_get(url, callback) {
  var xhr = new XMLHttpRequest()
      xhr.responseType = 'json'
      xhr.open("GET", url, true)
      xhr.send()
      xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200)
              callback(xhr.response)
      }
}

function send() {
    let name = document.getElementById('name'),
        message = document.getElementById('message')
	name.disabled = true
	message.disabled = true
    if(name.value.trim() != "" && message.value.trim() != "")
        ajax_get('/?addMessage=' + name.value + ': ' + message.value, function(response){
	    message.value = "" //clear what you just said
	    message.disabled = false
            console.log(response) //see message sent
        })
    else
        alert("Please fill in everything!")
    
}
//check for new messages every second
setInterval(function(){ 
    ajax_get('/?newMessages=' + messagesCount, function(response) {
        let newMessages = response
        for(let i = 0; i < newMessages.length; i++) {
            document.getElementById('messages').innerHTML += newMessages[i] + "<br>"
            messagesCount++
        }
    })

}, 1000);

window.onload = function() {
  document.getElementById('message').addEventListener('keydown', function (e) {
    var key = e.which || e.keyCode;
    if (key == 13) // 13 is enter (you have hit the enter key)
      send()
  });
}
</script>
<div id='messages'></div>
<a href='register.php'>Register page ... Totally unrelated</a><br>
<input id='name' placeholder="Your Nickname Here ..."> <br>
<input id='message' placeholder="Type message here ..."> <br>
<button onclick='send()'>Send Message</button> 
