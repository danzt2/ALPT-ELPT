#!/usr/bin/perl  

 
use LWP::Simple;
use REST::Client;
$enodeb = '';
$edate='';
$date = '';
$yr = 0;
$mo = 0;
$mm = '';
$dy = 0;
$rcnt=0;
$acnt=@ARGV;
if ($acnt < 1) {
  print "Input file is required\n";
  exit(1);
}
$in_fl=$ARGV[0];

 system("mv documents/*.csv documents/dump/.");

open (IN_H, "< $in_fl" ) or die "Can not open file: $in_fl\n$!\n";

while ($line_in = <IN_H>) {
  $rcnt++;
  $enodeb = substr($line_in,0,6);
  $date = substr($line_in,7,10);
  $yr = substr($line_in, 7,4);
  $mo = substr($line_in,12,2);
  $dy = substr($line_in,15,2);
 #logic to set the date 35 day forward in order grab a 35 day range from the activation date
  if ($mo == 12){
	if ($dy <= 26){
		$mm = '01';
		$yr++;
		$dy = $dy + 5;
	}else{
		$mm = '02';
		$yr++;
		$dy = $dy - 26;
	}
  }
  
  if ($mo == 1){
	if ($dy <= 23){
		$mm = '02'; 
		$dy = $dy + 5;
	}else{
		$mm = '03';
		$dy = $dy - 23;
	}
  }
  
  if ($mo == 2){
	if ($dy <= 26){
		$mm = '03'; 
		$dy = $dy + 5;
	}else{
	$mm = '04'; 
	$dy = $dy - 26;
	}
  }
  
  if ($mo == 3){
	if ($dy <= 25){
		$mm = '04';
		$dy = $dy + 4;
	}else{
		$mm = '05'; 
		$dy = $dy - 25;
	}
  }
  
  if ($mo == 4){
	if ($dy <= 26){
		$mm = '05'; 
		$dy = $dy + 5;
	}else{
		$mm = '06'; 
		$dy = $dy - 26;
	}
  }
  
  if ($mo == 5){
	if ($dy <= 25){
		$mm = '06';
		$dy = $dy + 4;
	}else{
		$mm = '07'; 
		$dy = $dy - 25;
	}
  }
  
  if ($mo == 6){
	if ($dy <= 26){
		$mm = '07'; 
		$dy = $dy + 5;
	}else{
		$mm = '08';
        $dy = $dy - 26;		
	}
  }
  
  if ($mo == 7){
	if ($dy <= 26){
		$mm = '08'; 
		$dy = $dy + 5;
	}else{
		$mm = '09'; 
		$dy = $dy - 26;
	}
  }
  
  if ($mo == 8){
	if ($dy <= 25){
		$mm = '09'; 
		$dy = $dy + 4;
	}else{
		$mm = '10';
        $dy = $dy - 25;		
	}
  }
  
  if ($mo == 9){
     if ($dy <= 26){
        $mm = '10';
        $dy = $dy + 5;
     }else{
        $mm = '11';
		$dy = $dy - 26;
  }
  }
  
  if ($mo == 10){
     if ($dy <= 25){
        $mm = '11';
        $dy = $dy + 4;
     }else{
        $mm = '12';
		$dy = $dy - 25;
         }
  }
  
  if ($mo == 11){
	if ($dy <= 26){
		$mm = '12'; 
		$dy = $dy + 5;
   }else{
        $mm = '13';
		$dy = $dy - 26;
         }
  }

	
  $edate = $yr."-".$mm."-".$dy;
  print $edate;

my $client = REST::Client->new();
$client->GET("http://alpt.vh.eng.vzwcorp.com:8282/alte/reportWebService.htm?action=exectmpl&tmpl_rpt=c0thd15|||ROI Neighbors&user=c0thd15&name=ROI_NEIGHBORS&edate=$edate&enodeb=$enodeb");

#print "http://alpt.vh.eng.vzwcorp.com:8282/alte/reportWebService.htm?action=exectmpl&tmpl_rpt=c0thd15|||ROI Neighbors&user=c0chaa8&name=ROI_NEIGHBORS&edate=2015-01-08&enodeb=$enodeb";
 

                   

 
open my $out, ">", $rcnt."Neighbors.csv" or die $!;


   
    
   print $out $client->responseContent();

$client = '';

close $out; 
print $enodeb "\n";
  }
  close IN_H;
 system("mv *Neighbors.csv documents/.");
print "\n Done!\n";