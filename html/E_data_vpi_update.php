<?php
require_once FRAMEWORKPATH.'/includes/pdo.php';
ini_set('memory_limit', '2G');
try {
	$conn = getPDO('WestAreaSystemPerformance');

 
$sql = "UPDATE `e_data`  
    JOIN e_sector_vpi ON e_data.neighbor_id = e_sector_vpi.sector_vpi_id
SET Broken_Sector_VPI = 1
where e_data.neighbor_id = e_sector_vpi.sector_vpi_id";
 
$q = $conn->query($sql); 
$q->closeCursor();

} catch (PDOException $pe) {
die("Could not connect to the database $dbname :" . $pe->getMessage());
}

try {
	$conn = getPDO('WestAreaSystemPerformance');

 
$sql = "UPDATE `e_data`  
    JOIN e_broken_sector ON e_data.neighbor_id = e_broken_sector.broken_sector_id
SET `Broken_Sector_<5Mbps` = 1
where e_data.neighbor_id = e_broken_sector.broken_sector_id";
 
$q = $conn->query($sql); 
$q->closeCursor();

} catch (PDOException $pe) {
die("Could not connect to the database $dbname :" . $pe->getMessage());
}
header("Location: https://irvecaqg-wadtr-vm20.nss.vzwnet.com/query/E_performance_query.php");
?>