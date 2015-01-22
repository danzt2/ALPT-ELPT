<?php
$upload_path = '/var/www/html';
if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_path.'/'.$_FILES['file']['name'])) {
}

exec("perl ROI_Neighbors.pl enodeb_list.txt");

header("Location: https://irvecaqg-wadtr-vm20.nss.vzwnet.com/documents/merge.php");

?>
<html>
<head>
<title>Uploading Complete</title>
</head>
<body>
<h2>Uploaded File Info:</h2>
<ul>
<li>Sent file: <?php echo $_FILES['file']['name'];  ?>
<li>File size: <?php echo $_FILES['file']['size'];  ?> bytes
<li>File type: <?php echo $_FILES['file']['type'];  ?>
</ul>
</body>
</html>
