<?php
session_start();
if (!isset($_SESSION["usrname"]) || $_SESSION["usrname"] == "") {
  ?>
	<html lang="">
	<head>
		<title>Chat Room Example</title>
		<link rel="stylesheet" href="css/main.css"/>
	</head>
	<body>
	<h1>Please choose a nickname and a color</h1>
	<form action="login.php" method="post">
		<table cellpadding="5" cellspacing="0" border="0">
			<tr>
				<td align="left" valign="top">Nickname :</td>
				<td align="left" valign="top">
					<label>
						<input type="text" name="usrname"/>
					</label>
				</td>
			</tr>
			<tr>
				<td align="left" valign="top">Color :</td>
				<td align="left" valign="top">
					<label>
						<select name="color">
							<option value="000000">Black</option>
							<option value="7B1FA2">Purple</option>
							<option value="03A9F4">Aqua</option>
							<option value="FFAB3B">Yellow</option>
							<option value="00897B">Teal</option>
							<option value="6D4C41">Brown</option>
							<option value="F57C00">Orange</option>
							<option value="616161">Gray</option>
							<option value="1976D2">Blue</option>
							<option value="388E3C">Green</option>
							<option value="FF00FF">Magenta</option>
							<option value="D50000">Red</option>
						</select>
					</label>
				</td>
			</tr>
			<tr>
				<td align="left" valign="top"></td>
				<td align="left" valign="top"><input type="submit" value="Login"/></td>
			</tr>
		</table>
	</form>
	</body>
	</html>
  <?php
}
else {
  ?>
	<html lang="">
	<head>
		<title>Chat Room Example</title>
		<script src="js/jquery.min.js"></script>
		<script src="js/main.js"></script>
		<link rel="stylesheet" href="css/main.css"/>
	</head>
	<body>
	<div id="view_ajax"></div>
	<div id="ajaxForm">
		<label for="chatInput"></label><input type="text" id="chatInput"/><input type="button" value="Send" id="btnSend"/>
	</div>
	</body>
	</html>
<?php }
