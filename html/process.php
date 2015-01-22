<?php 

	exec("perl ROI_Report.pl ".date("Y")."-".date("M")."-".date("D"));
 
  
header("Location: https://irvecaqg-wadtr-vm20.nss.vzwnet.com/processClean.php"); 


?>