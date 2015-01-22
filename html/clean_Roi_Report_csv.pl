#!/usr/bin/perl 
use strict;

# Set to filename of CSV file
my $csvfile = 'ROI_Report.csv';

my $newfile = 'ROI_Report_Clean.csv';

my $fieldnames = 1;
open (IN, "<$csvfile")  or die "Couldn't open input CSV file: $!";
open (OUT, ">$newfile") or die "Couldn't open output file: $!";

# Read header lines if they exist
my $header;

$header = <IN> if $fieldnames;

# Slurp in & sort everything else
my @data = sort <IN>;

# If we read in a header line, throw it back out again
print OUT $header;

my $n = 0;

# to the previous line (in which case it's a dupe)
my $lastline = '';
foreach my $currentline (@data) {
 	

	$currentline =~ s/Total.*//g;



	
	
  next if $currentline eq $lastline;
  print OUT $currentline;
  $lastline = $currentline;
  $n++;
}

close IN; close OUT;

print "Processing complete. In = " . scalar @data . " records, Out =
$n records\n";



