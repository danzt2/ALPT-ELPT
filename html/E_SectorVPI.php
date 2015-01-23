<?php
require_once FRAMEWORKPATH.'/includes/pdo.php';
ini_set('memory_limit', '2G');



$message = null; 

            $db = getPDO('WestAreaSystemPerformance');
			$db->exec("SET CHARACTER SET utf8");
  
$content = file_get_contents("/var/www/html/E_DEC_VPI.txt");
$lines = explode("\n", $content);
foreach ($lines as $line) {	
    $row = explode("\n ", $line);   
  $sql = "INSERT INTO e_sector_vpi SET sector_vpi_id = '" . trim($row[0]) . "'";
 //echo $sql;
	$SQL = $db->prepare($sql);
		$SQL->execute();
}

header("Location: https://irvecaqg-wadtr-vm20.nss.vzwnet.com/E_BrokenSector.php");

?>
