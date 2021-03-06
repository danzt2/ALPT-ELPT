<?php
require_once FRAMEWORKPATH.'/includes/pdo.php';
ini_set('memory_limit', '2G');

copy('/var/www/html/DEC_BrokenSector.txt', '/var/www/html/documents/dump/DEC_BrokenSector.txt');
unlink('/var/www/html/DEC_BrokenSector.txt');
copy('/var/www/html/DEC_VPI.txt', '/var/www/html/documents/dump/DEC_VPI.txt');
unlink('/var/www/html/DEC_VPI.txt');
 
try {
	$conn = getPDO('WestAreaSystemPerformance');

$sql = "SELECT *
FROM `data`";
 
$q = $conn->query($sql);
$q->setFetchMode(PDO::FETCH_ASSOC);
 
} catch (PDOException $pe) {
die("Could not connect to the database $dbname :" . $pe->getMessage());
}
?>

<button id="myButton" class="float-left submit-button" >Home</button>

<script type="text/javascript">
    document.getElementById("myButton").onclick = function () {
        location.href = "https://irvecaqg-wadtr-vm20.nss.vzwnet.com";
    };
</script>

<!DOCTYPE html>
<html>
<style>
tr:nth-child(even) {
    background-color: #C2F0C2;
}
</style>
<head>
<title>PHP MySQL Query Data Demo</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
</head>
<body>
<form action="excel_download.php" method="post"
                        enctype="multipart/form-data">
		<input type="submit" value="Export Excel" />
</form>				
<div id="container">
<h1>Performance</h1>
<table class="table table-bordered table-condensed" border="1" cellpadding="3" cellspacing="1" >
<thead>
<tr>
<th>ID</th>
<th>Activation_Date</th>
<th>Before_Date</th>
<th>After_Date</th>
<th>New_Build_Name</th>
<th>New_Build_ID</th>
<th>New_Build</th>
<th>Neighbor_Name</th>
 <th>Neighbor_ID</th>
 <th>Broken_Sector_VPI</th>
 <th>Broken_Sector_5Mbps</th>
 <th>Sector_ID</th>
 <th>HO_Att</th>
 <th>PDCP_DL_DataVol_MB_Before</th>
  <th>PDCP_DL_DataVol_MB_After</th>
  <th>PDCP_DL_DataVol_MB_Offload</th>
  <th>UE_Downlink_Throughput_Before</th>
  <th>UE_Downlink_Throughput_After</th>
  <th>UE_Downlink_Throughput_Offload</th>
  <th>AVG_CQI_ERC_Before</th>
 <th>AVG_CQI_ERC_After</th>
 <th>AVG_CQI_ERC_Offload</th>
</tr>
</thead>
<tbody>
<?php while ($r = $q->fetch()): ?>
<tr>
<td><?php echo htmlspecialchars($r['ID'])?></td>
<td><?php echo htmlspecialchars($r['Activation_Date']); ?></td>
<td><?php echo htmlspecialchars($r['Before_Date']); ?></td>
<td><?php echo htmlspecialchars($r['After_Date']); ?></td>
<td><?php echo htmlspecialchars($r['New_Build_Name']); ?></td>
<td><?php echo htmlspecialchars($r['New_Build_ID']); ?></td>
<td><?php echo htmlspecialchars($r['New_Build']); ?></td>
<td><?php echo htmlspecialchars($r['Neighbor_Name']); ?></td>
<td><?php echo htmlspecialchars($r['Neighbor_ID']); ?></td>
<td><?php echo htmlspecialchars($r['Broken_Sector_VPI']); ?></td>
<td><?php echo htmlspecialchars($r['Broken_Sector_<5Mbps']); ?></td>
<td><?php echo htmlspecialchars($r['Sector_ID']); ?></td>
<td><?php echo htmlspecialchars($r['HO_Att']); ?></td>
<td><?php echo htmlspecialchars($r['PDCP_DL_DataVol_MB_Before']); ?></td>
<td><?php echo htmlspecialchars($r['PDCP_DL_DataVol_MB_After']); ?></td>
<td><?php echo htmlspecialchars($r['PDCP_DL_DataVol_MB_Offload']); ?></td>
<td><?php echo htmlspecialchars($r['UE_Downlink_Throughput_Before']); ?></td>
<td><?php echo htmlspecialchars($r['UE_Downlink_Throughput_After']); ?></td>
<td><?php echo htmlspecialchars($r['UE_Downlink_Throughput_Offload']); ?></td>
<td><?php echo htmlspecialchars($r['AVG_CQI_ERC_Before']); ?></td>
<td><?php echo htmlspecialchars($r['AVG_CQI_ERC_After']); ?></td>
<td><?php echo htmlspecialchars($r['AVG_CQI_ERC_Offload']); ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</body>
</div>
</html>