<?php
require_once FRAMEWORKPATH.'/includes/pdo.php';
ini_set('memory_limit', '2G');

//clean out previous data
try {
	$conn = getPDO('WestAreaSystemPerformance');

 
$sql = "TRUNCATE TABLE e_neighbor_performance";
 
$q = $conn->query($sql); 
$q->closeCursor();

} catch (PDOException $pe) {
die("Could not connect to the database $dbname :" . $pe->getMessage());
}

try {
	$conn = getPDO('WestAreaSystemPerformance');

 
$sql = "TRUNCATE TABLE e_tmp_bfore";
 
$q = $conn->query($sql); 
$q->closeCursor();

} catch (PDOException $pe) {
die("Could not connect to the database $dbname :" . $pe->getMessage());
}

try {
	$conn = getPDO('WestAreaSystemPerformance');

 
$sql = "TRUNCATE TABLE e_tmp_aftr";
 
$q = $conn->query($sql); 
$q->closeCursor();

} catch (PDOException $pe) {
die("Could not connect to the database $dbname :" . $pe->getMessage());
}


//have to remove weekends 
try {
	$conn = getPDO('WestAreaSystemPerformance');

 
$sql = "DELETE FROM `e_roi_report` WHERE dayofweek(STR_TO_DATE(DAY,'%m/%d/%Y')) in (1,7);";
 
$q = $conn->query($sql);

 
} catch (PDOException $pe) {
die("Could not connect to the database $dbname :" . $pe->getMessage());
}
 
 
try {
	$conn = getPDO('WestAreaSystemPerformance');

 
$sql = "INSERT IGNORE INTO e_neighbor_performance (NEW_BUILD_NAME, ACTIVE_DAY, ENODEB,EUTRANCELL, NEIGHBOR, DAY, HR, DL_RLC_Layer_MByte, NEIGHBOR_NAME, HO_Att, UE_Downlink_Throughput, AVG_CQI_ERC)
SELECT e_enodeb_neighbors.SITE, (STR_TO_DATE(e_enodeb_neighbors.DAY,'%m-%d-%Y')) - INTERVAL 35 DAY, e_enodeb_neighbors.ENODEB, e_enodeb_neighbors.EUTRANCELL, e_enodeb_neighbors.EUTRANCELLRELATION, STR_TO_DATE(e_roi_report.DAY,'%m/%d/%Y'), e_roi_report.HR, e_roi_report.PDCP_DL_DataVol_MB, e_roi_report.SITE, e_enodeb_neighbors.Handover_Attempts_Nb, e_roi_report.UE_Downlink_Throughput, e_roi_report.AVG_CQI_ERC
FROM e_enodeb_neighbors
JOIN e_roi_report ON e_enodeb_neighbors.EUTRANCELLRELATION like CONCAT('%', e_roi_report.ENODEB, '_',e_roi_report.EUTRANCELL,'%' )";
 
$q = $conn->query($sql);

 
} catch (PDOException $pe) {
die("Could not connect to the database $dbname :" . $pe->getMessage());
}

header("Location: https://irvecaqg-wadtr-vm20.nss.vzwnet.com/query/E_populate_data_table.php");	

?>
