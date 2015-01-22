#!/usr/bin/perl  
use strict; 
use warnings; 
use autodie;

my $cnt = 0;
#my $out_fl = "Total_Neighbors.csv";
#my @files = <*.csv>;
# for my $file (@files) {
#$cnt++;
#if ($file = $cnt."Neighbors.csv"){
#    push @ARGV, $file;
#      }
# }

#open my $out, ">", "Totals.csv" or die $!;

#while (my $file = shift @ARGV) {
#  open my $fh, "<", $file;
#  <$fh> unless my $files == @ARGV; # discard header unless first file
# print while <$fh>; 
#}


#close $out;
#print "Done";


my $result_file = shift @ARGV;

my $pattern = shift @ARGV;
my @file_list = <*.csv>;

open( my $out_fh, '>:encoding(utf8)', "Totals.csv" ) or die "Could not open '$result_file': $!\n";

foreach my $in_file (@file_list) {

$cnt++;
if ($in_file = $cnt."Neighbors.csv"){
   open( my $in_fh, '<:encoding(utf8)', $in_file ) or die "Could not open '$in_file': $!\n"; 
   while (<$in_fh>) {
   
      chomp;
	  
      print $out_fh $_ . ',' . "\n" ;
      }
   close ($in_fh);
   }
}
close ($out_fh);



