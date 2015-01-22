<?PHP

require_once FRAMEWORKPATH.'/includes/pdo.php';
ini_set('memory_limit', '2G');
 
try {
	$conn = getPDO('WestAreaSystemPerformance');

$sql = "SELECT *
FROM `e_data`";
 
$q = $conn->query($sql);
$q->setFetchMode(PDO::FETCH_ASSOC);
 
} catch (PDOException $pe) {
die("Could not connect to the database $dbname :" . $pe->getMessage());
}



  function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // filename for download
  $filename = "ELTE_ROI_data_" . date('Ymd') . ".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  foreach($q as $row) {
    if(!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row)) . "\r\n";
      $flag = true;
    }
    array_walk($row, 'cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
  }
  exit;
?>