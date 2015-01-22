#!/usr/bin/perl  
#use strict; 
use warnings;

use LWP::Simple;
use REST::Client;
 
$acnt=@ARGV;
if ($acnt < 1) {
  print "date is required\n";
  exit(1);
}
$edate=$ARGV[0];
# system("mv ROI_Report*.csv documents/dump/.");
print $edate;
my $client = REST::Client->new();
$client->setTimeout(1000);
$client->GET("http://alpt.vh.eng.vzwcorp.com:8282/alte/reportWebService.htm?action=exectmpl&tmpl_rpt=c0thd15|||ROI Report&user=c0chaa8&name=ROI_Report&edate=$edate&num_days=100");
#$client->GET("http://alpt.vh.eng.vzwcorp.com:8282/alte/reportWebService.htm?action=exectmpl&tmpl_rpt=c0thd15|||ROI Report&user=c0thd15&name=ROI_Report&edate=2014-11-30&num_days=100");

 

                   

 
open my $out, ">", "ROI_Report.csv" or die $!;


   
    
    print $out $client->responseContent();



close $out; 
 
print "\n Done!\n"; 