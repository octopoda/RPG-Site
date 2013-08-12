<html>
<head>
<title>Folder and File Permission Fixer</title>
</head>
<body>
<form name="form1" method="post" action="">

<?php
if ($_POST[d] == "Yes and Go") {
	system ('find ./ -type f -exec chmod 644 {} \;'); 
	system ('find ./ -type d -exec chmod 755 {} \;');
	system ('find ./ -name \*.cgi -exec chmod 755 {} \;');
	system ('find ./ -name \*.pl -exec chmod 755 {} \;'); 
	system ('find ./ -name \*.pm -exec chmod 755 {} \;');
	echo '</br>Done.';
} else {
	echo'<h1>This utility will change the permissions to the parent and all of the parents subfolders.</h1><h3>(please place this file in the root of the public_html to be most effective.) </h3>';
	echo'<h3>Set all Files = 644 ???</h3><h3>Set all Folders = 755 ???</h3><h3>Set all cgi and pl and pm files = 755 ???</h3>';
	echo '<input type="submit" value="Yes and Go" name="d">'; 
}
	

?>

</body>
</html>