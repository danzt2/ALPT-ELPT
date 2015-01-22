#!/usr/bin/perl  
use strict; 
use warnings; 
use autodie;

my $cnt = 0;



my $result_file = shift @ARGV;

my $pattern = shift @ARGV;
my @file_list = <*.csv>;

open( my $out_fh, '>:encoding(utf8)', "E_Totals.csv" ) or die "Could not open '$result_file': $!\n";

foreach my $in_file (@file_list) {

$cnt++;
if ($in_file = $cnt."Neighbors_E.csv"){
   open( my $in_fh, '<:encoding(utf8)', $in_file ) or die "Could not open '$in_file': $!\n"; 
   while (<$in_fh>) {
   
      chomp;
	  
      print $out_fh $_ . ',' . "\n" ;
      }
   close ($in_fh);
   }
}
close ($out_fh);



