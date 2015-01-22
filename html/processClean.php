<?php

       
	exec("perl clean_Roi_Report_csv.pl");
 
  
header("Location: https://irvecaqg-wadtr-vm20.nss.vzwnet.com/csv2mysql_roiReport.php"); 


?>