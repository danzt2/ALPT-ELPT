<?php
require_once FRAMEWORKPATH.'/includes/pdo.php';
ini_set('memory_limit', '2G');

try {
	$conn = getPDO('WestAreaSystemPerformance');

 
$sql = "TRUNCATE TABLE enodeb_neighbors";
 
$q = $conn->query($sql); 
$q->closeCursor();

} catch (PDOException $pe) {
die("Could not connect to the database $dbname :" . $pe->getMessage());
}


$message = null;
	
		if ((  $handle =  fopen("/var/www/html/documents/Totals_clean.csv", "r"))!== false){
			
			$db = getPDO('WestAreaSystemPerformance');
			$db->exec("SET CHARACTER SET utf8");
			
			$headers = fgetcsv($handle); //get headers
			$SQLtext = "INSERT IGNORE INTO enodeb_neighbors SET ";
			foreach ($headers as $header) {
				$SQLtext .= "$header = :$header,";
			}
			$SQLtext = substr($SQLtext, 0, -1); //strip trailing comma
                       
			$SQL = $db->prepare($SQLtext);
			
			$line = 1;
			while (($row = fgetcsv($handle, 0, ',','"')) !== false) {
				$count = count($row);
				for ($i=0;$i<$count;$i++) {
					$$headers[$i] = $row[$i];
				}
				foreach ($headers as $header) {
					$SQL->bindParam(":$header", $$header, PDO::PARAM_STR);
				}
				$SQL->execute();
			}
			fclose($handle);}
else{
	$message = '<span class=red> could not open file</span>';
}
			
header("Location: https://irvecaqg-wadtr-vm20.nss.vzwnet.com/process.php");	


?>


