<?php
require_once FRAMEWORKPATH.'/includes/pdo.php';
ini_set('memory_limit', '2G');
//clean out previous data
try {
	$conn = getPDO('WestAreaSystemPerformance');

 
$sql = "TRUNCATE TABLE neighbor_performance";
 
$q = $conn->query($sql); 
$q->closeCursor();

} catch (PDOException $pe) {
die("Could not connect to the database $dbname :" . $pe->getMessage());
}

try {
	$conn = getPDO('WestAreaSystemPerformance');

 
$sql = "TRUNCATE TABLE tmp_bfore";
 
$q = $conn->query($sql); 
$q->closeCursor();

} catch (PDOException $pe) {
die("Could not connect to the database $dbname :" . $pe->getMessage());
}

try {
	$conn = getPDO('WestAreaSystemPerformance');

 
$sql = "TRUNCATE TABLE tmp_aftr";
 
$q = $conn->query($sql); 
$q->closeCursor();

} catch (PDOException $pe) {
die("Could not connect to the database $dbname :" . $pe->getMessage());
}


//have to remove weekends 
try {
	$conn = getPDO('WestAreaSystemPerformance');

 
$sql = "DELETE FROM `roi_report` WHERE dayofweek(STR_TO_DATE(DAY,'%m/%d/%Y')) in (1,7);";
 
$q = $conn->query($sql);

 
} catch (PDOException $pe) {
die("Could not connect to the database $dbname :" . $pe->getMessage());
}
 
 
 
 try {
	$conn = getPDO('WestAreaSystemPerformance');

 
$sql = "INSERT IGNORE INTO neighbor_performance (NEW_BUILD_NAME, ACTIVE_DAY, ENODEB,EUTRANCELL, NEIGHBOR, DAY, HR, DL_RLC_Layer_MByte, NEIGHBOR_NAME, HO_Att, UE_Downlink_Throughput, AVG_CQI_ERC)
SELECT enodeb_neighbors.SITE, (STR_TO_DATE(enodeb_neighbors.DAY,'%m-%d-%Y')) - INTERVAL 35 DAY, enodeb_neighbors.ENODEB, enodeb_neighbors.EUTRANCELL, enodeb_neighbors.LTEINTRAFREQNCEllREL, STR_TO_DATE(roi_report.DAY,'%m/%d/%Y'), roi_report.HR, roi_report.DL_RLC_Layer_MByte, roi_report.SITE, enodeb_neighbors.OgIntrFrHOMEvt_Rel, roi_report.USER_PRCVD_TPUT_NonGBR, roi_report.AVG_CQI_ALL_R13_3
FROM enodeb_neighbors
JOIN roi_report ON enodeb_neighbors.LTEINTRAFREQNCEllREL like CONCAT('%', roi_report.ENODEB, '-',roi_report.EUTRANCELL,'%' )";
 
$q = $conn->query($sql);

 
} catch (PDOException $pe) {
die("Could not connect to the database $dbname :" . $pe->getMessage());
}

header("Location: https://irvecaqg-wadtr-vm20.nss.vzwnet.com/query/populate_data_table.php");	

?>
