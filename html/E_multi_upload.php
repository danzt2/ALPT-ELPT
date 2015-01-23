<?php
require_once ABSOLUTEPATH.'/classes/AppPage.class.php';

/** STEP 1: Instantiate the page object. This includes a security check. **/
try {
	$page = new AppPage('West Area', 'ROI');
}
catch (Exception $e) {
	echo '<p style="color: #FF0000; text-align: center; width: 100%">'.$e->getMessage().'</p>';
}

/** STEP 2 (Optional): Create any page-specific CSS and add it to the page **/
$css = '
	<style type="text/css">
		.contentcontainer .center {margin: 1em auto;}
	</style>
';
$page->setStyle($css);

/** STEP 3 (Optional): Create any page-specific Javascript and add it to the page **/
$page->setScript('');
$body = '<h2 class="center">*** ELPT ROI REPORT PROCESS ***</h2>';
$body .= '<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Multiple File Upload</title>
</head>
<body>
<h3>Upload Files:</h3>
 <br />
  <form action="E_NeighborsRetrieve.php" method="post" enctype="multipart/form-data">
  <table width="400" border="1" cellpadding="3" cellspacing="1">
   <tr>
    <th>
	Select files to upload:
	</th>
	<th>
	Naming convention:
	</th>
   </tr>	
    
<tr>
   <td>
       <input type="file" id="file" name="files[]" />
   </td>
    <td>
        E_BrokenSector.txt
    </td>
</tr>
<tr>
   <td>
	    <input type="file" id="file" name="files[]" />
   </td>
   <td>
	  E_VPI.txt
   </td>
 </tr>
<tr>
  <td>
	 <input type="file" id="file" name="files[]" />
  </td>
  <td>
	 E_enodeb_list.txt
  </td>
</tr>
<tr> 
  <td>
    <input type="submit" value="Upload!" />
  </td>
</tr>
  </table>
  <br/>
  <br/>
</form>
</body>
</html>';
$page->setBody($body);

/** STEP 5: Output the completed page **/
$page->display();

?>

