<?php
copy('/var/www/html/E_enodeb_list.txt', '/var/www/html/documents/dump/E_enodeb_list.txt');
unlink('/var/www/html/E_enodeb_list.txt');
?>

<!DOCTYPE HTML>
<html lang="en">
<html>
<head>
<title>Text File Uploading Form</title>
</head>
<body>
<h3>File Upload:</h3>
Select a file to upload: <br />
<form action="E_uploader.php" method="post"
                        enctype="multipart/form-data">
<input type="file" name="file" size="50" />
<br />
<input type="submit" value="Upload File" />
</form>


</body>
</html>