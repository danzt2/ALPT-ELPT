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
print $edate;
my $client = REST::Client->new();
$client->setTimeout(1000);
$client->GET("http://elpt.vh.eng.vzwcorp.com:8181/elte/reportWebService.htm?action=exectmpl&tmpl_rpt=c0thd15|||ROI Report&user=c0chaa8&name=ROI_Report&edate=$edate&num_days=100");
# $client->GET("http://elpt.vh.eng.vzwcorp.com:8181/elte/reportWebService.htm?action=exectmpl&tmpl_rpt=c0thd15|||ROI Report&user=c0chaa8&name=ROI_Report&edate=2014-11-30&num_days=100");
open my $out, ">", "E_ROI_Report.csv" or die $!;
  
    print $out $client->responseContent();

close $out; 
 
print "\n Done!\n"; 