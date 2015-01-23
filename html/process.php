<?php 
copy('/var/www/html/enodeb_list.txt', '/var/www/html/documents/dump/enodeb_list.txt');
unlink('/var/www/html/enodeb_list.txt');

	exec("perl ROI_Report.pl ".date("Y")."-".date("M")."-".date("D"));
 
  
header("Location: https://irvecaqg-wadtr-vm20.nss.vzwnet.com/processClean.php"); 


?>