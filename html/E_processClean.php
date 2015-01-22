<?php

       
	exec("perl E_clean_Roi_Report_csv.pl");
 
  
header("Location: https://irvecaqg-wadtr-vm20.nss.vzwnet.com/E_csv2mysql_roiReport.php"); 


?>