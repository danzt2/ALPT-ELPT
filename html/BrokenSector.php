<?php
require_once FRAMEWORKPATH.'/includes/pdo.php';
ini_set('memory_limit', '2G');

exec("sed -i -e 's/_/-/g' DEC_BrokenSector.txt");

$message = null; 

            $db = getPDO('WestAreaSystemPerformance');
			$db->exec("SET CHARACTER SET utf8");
  
$content = file_get_contents("/var/www/html/DEC_BrokenSector.txt");
$lines = explode("\n", $content);
foreach ($lines as $line) {	
    $row = explode("\n ", $line);   
  $sql = "INSERT INTO broken_sector SET broken_sector_id = '" . trim($row[0]) . "'";
 //echo $sql;
	$SQL = $db->prepare($sql);
		$SQL->execute();
}

header("Location: https://irvecaqg-wadtr-vm20.nss.vzwnet.com/query/data_vpi_update.php");

?>
