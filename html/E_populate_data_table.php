<?php
require_once FRAMEWORKPATH.'/includes/pdo.php';
ini_set('memory_limit', '2G');

//clean out data table
copy('/var/www/html/ROI_Report.csv', '/var/www/html/documents/dump/ROI_Report.csv');
unlink('/var/www/html/ROI_Report.csv');
copy('/var/www/html/ROI_Report_Clean.csv', '/var/www/html/documents/dump/ROI_Report_Clean.csv');
unlink('/var/www/html/ROI_Report_Clean.csv');

 try {
	$conn = getPDO('WestAreaSystemPerformance');

 
$sql = "TRUNCATE TABLE data";
 
$q = $conn->query($sql); 
$q->closeCursor();

} catch (PDOException $pe) {
die("Could not connect to the database $dbname :" . $pe->getMessage());
}
 
try {
	$conn = getPDO('WestAreaSystemPerformance');

 
$sql = "INSERT INTO e_tmp_bfore (ACTIVE_DAY,BEFORE_DATE,NEW_BUILD_NAME, ENODEB, EUTRANCELL, NEIGHBOR_NAME, NEiGHBOR, VOl_Before, ho_att, tput_before, avgcqi_before)
SELECT `ACTIVE_DAY`,`ACTIVE_DAY` - INTERVAL 35 DAY,`NEW_BUILD_NAME`, `ENODEB`, `EUTRANCELL`, `NEIGHBOR_NAME`, `NEiGHBOR` , AVG( `DL_RLC_Layer_MByte`) , AVG(`HO_Att`), AVG(`UE_Downlink_Throughput`), AVG(`AVG_CQI_ERC`) 
FROM `e_neighbor_performance`
WHERE (`DAY` between(`ACTIVE_DAY` - INTERVAL 35 DAY) and (`ACTIVE_DAY` - INTERVAL 5 DAY) OR `DAY` IS NULL)
GROUP BY `NEiGHBOR`;";
 
$q = $conn->query($sql); 
$q->closeCursor();

} catch (PDOException $pe) {
die("Could not connect to the database $dbname :" . $pe->getMessage());
}

try {

$conn = getPDO('WestAreaSystemPerformance');

$sql = "insert into e_tmp_aftr(ACTIVE_DAY,AFTER_DATE, ENODEB, NEiGHBOR, VOL_After, tput_after, avgcqi_after)
SELECT `ACTIVE_DAY`,`ACTIVE_DAY` + INTERVAL 35 DAY, `ENODEB` , `NEiGHBOR` , AVG( `DL_RLC_Layer_MByte` ),  AVG(`UE_Downlink_Throughput`), AVG(`AVG_CQI_ERC`) 
FROM `e_neighbor_performance`
WHERE (`DAY` between(`ACTIVE_DAY` + INTERVAL 5 DAY) and (`ACTIVE_DAY` + INTERVAL 35 DAY) OR `DAY` IS NULL)
GROUP BY `NEiGHBOR`;";
$q = $conn->query($sql); 
$q->closeCursor(); 

} catch (PDOException $pe) {
die("Could not connect to the database $dbname :" . $pe->getMessage());
}

try {
	$conn = getPDO('WestAreaSystemPerformance');

	$SQLtext = "INSERT INTO `e_data`(Activation_Date, Before_Date, After_Date, New_Build_Name, New_Build_ID, New_Build,Neighbor_Name, Neighbor_ID, Sector_ID, HO_Att, PDCP_DL_DataVol_MB_Before, PDCP_DL_DataVol_MB_After, PDCP_DL_DataVol_MB_Offload, UE_Downlink_Throughput_Before, UE_Downlink_Throughput_After, UE_Downlink_Throughput_Offload, AVG_CQI_ERC_Before, AVG_CQI_ERC_After, AVG_CQI_ERC_Offload)
SELECT e_tmp_bfore.ACTIVE_DAY,e_tmp_bfore.BEFORE_DATE,e_tmp_aftr.AFTER_DATE,e_tmp_bfore.NEW_BUILD_NAME, concat(e_tmp_bfore.ENODEB,'-',e_tmp_bfore.EUTRANCELL),concat_ws('',e_tmp_bfore.enodeb, e_tmp_bfore.NEW_BUILD_NAME), e_tmp_bfore.NEIGHBOR_NAME, e_tmp_bfore.NEiGHBOR,concat_ws('',e_tmp_bfore.NEiGHBOR, e_tmp_bfore.NEIGHBOR_NAME),e_tmp_bfore.ho_att, e_tmp_bfore.VOl_Before, e_tmp_aftr.VOL_After, concat(round(( (e_tmp_aftr.VOL_After - e_tmp_bfore.VOl_Before)/e_tmp_bfore.VOl_Before * 100 ),2),'%'), e_tmp_bfore.tput_before, e_tmp_aftr.tput_after, concat(round(( (e_tmp_aftr.tput_after - e_tmp_bfore.tput_before)/e_tmp_bfore.tput_before * 100 ),2),'%'), e_tmp_bfore.avgcqi_before, e_tmp_aftr.avgcqi_after, concat(round(( (e_tmp_aftr.avgcqi_after - e_tmp_bfore.avgcqi_before)/e_tmp_bfore.avgcqi_before * 100 ),2),'%') 
FROM `e_tmp_bfore`
JOIN `e_tmp_aftr` on e_tmp_bfore.NEiGHBOR = e_tmp_aftr.NEiGHBOR and e_tmp_bfore.ENODEB = e_tmp_aftr.ENODEB;";
	
	$SQL = $conn->prepare($SQLtext);

 $SQL->execute();

} catch (PDOException $pe) {
die("Could not connect to the database $dbname :" . $pe->getMessage());
}
header("Location: https://irvecaqg-wadtr-vm20.nss.vzwnet.com/query/E_performance_query.php");

?>
