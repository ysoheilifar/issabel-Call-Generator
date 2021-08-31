<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
   background: linear-gradient( rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('pic1.jpg');
   background-size: cover;
   background-position: center;
}

h1 {
    color:white;
    margin:auto;
    width: 50%;
    border: 3px solid #008CBA;
    padding: 10px;
}

.w3-input {
    padding:8px;
    display:block;
    color:white;
    border:none;
    border-bottom:1px solid #008CBA;
    width:100%;
    background: linear-gradient( rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7));
}

button{
  background:#008CBA;
  color:#fff;
  border:none;
  position:relative;
  height:50px;
  font-size:1.6em;
  padding:0 2em;
  cursor:pointer;
  transition:800ms ease all;
  outline:none;
  border-radius: 4px;
}
button:hover{
  background:#fff;
  color:#008CBA;
  border-radius: 4px;
}
button:before,button:after{
  content:'';
  position:absolute;
  top:0;
  right:0;
  height:2px;
  width:0;
  background: #008CBA;
  transition:400ms ease all;
  border-radius: 4px;
}
button:after{
  right:inherit;
  top:inherit;
  left:0;
  bottom:0;
  border-radius: 4px;
}
button:hover:before,button:hover:after{
  width:100%;
  transition:800ms ease all;
  border-radius: 4px;
}

</style>
</head>
<body>
<br></br>
<br></br>
<h1><center>Zarbin Network Call Generator</center></h1>
<br></br>
<br></br>
<br></br>
<form action="callgen.php" method="POST">
<center>
<input type="text" class="w3-input" placeholder="Caller with prefix" name="caller" style="width:30%">
<br></br>
<input type="text" class="w3-input" placeholder="Callee with prefix" name="callee" style="width:30%">
<br></br>
<input type="text" class="w3-input" placeholder="SIP Trunk Name" name="trunk" style="width:30%">
<br></br>

<button id="button" type="submit" >Dial...</button>
<br></br>
<button id="button" type="reset" >Refresh</button>
</center>
</form>
</body>
</html>
<?php
$exten1 = $_POST['caller'];
$exten2 = $_POST['callee'];
$trunk = $_POST['trunk'];
$timeout = 5000;
$asterisk_ip = "192.168.1.10";
$socket = fsockopen($asterisk_ip,"5038", $errno, $errstr, $timeout );
fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: test\r\n");
fputs($socket, "Secret: 123456\r\n\r\n");
$wrets=fgets($socket,128);
fputs($socket, "Action: Originate\r\n");
fputs($socket, "Channel: SIP/$trunk/$exten1\r\n");
fputs($socket, "Exten: $exten2\r\n");
fputs($socket, "Context: from-internal\r\n");
fputs($socket, "Priority: 1\r\n");
fputs($socket, "Callerid: $exten1\r\n");
fputs($socket, "Async: yes\r\n");
$wrets=fgets($socket,128);
sleep (1);
$wrets=fgets($socket,128);
fputs($socket, "Action: Logoff\r\n\r\n");
fclose($socket);
?>