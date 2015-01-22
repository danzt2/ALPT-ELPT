#!/usr/bin/perl -w

# I place the following code 100% in the public domain.

use strict;

# Set to filename of CSV file
my $csvfile = 'Totals.csv';

# Set to filename of de-duped file (new file)
my $newfile = 'Totals_clean.csv';

# Set to 1 if first line of CSV file contains field names, 0 otherwise
my $fieldnames = 1;

### Shouldn't need to change stuff below here ###

open (IN, "<$csvfile")  or die "Couldn't open input CSV file: $!";
open (OUT, ">$newfile") or die "Couldn't open output file: $!";

# Read header lines if they exist
my $header;

$header = <IN> if $fieldnames;
chomp($header);
chop($header);
$header =~ s/\r/\n/g;
# Slurp in & sort everything else
my @data = sort <IN>;

# If we read in a header line, throw it back out again
print OUT $header;

my $n = 0;

# to the previous line (in which case it's a dupe)
my $lastline = '';
foreach my $currentline (@data) {
   
	chomp($currentline);
	chop($currentline);
	
	
    $currentline =~ s/311\/480\/.*\/.*\/ 311\/480\///g;
	$currentline =~ s/\//-/g; # not needed date format change but needed for neighbor enodeb and section format
	$currentline =~ s/Total.*//g;
	$currentline =~ s/DAY.*//g;
	$currentline =~ s/\r/\n/g;
	

	
	
  next if $currentline eq $lastline;
  print OUT $currentline;
  $lastline = $currentline;
  $n++;
}

close IN; close OUT;

print "Processing complete. In = " . scalar @data . " records, Out =
$n records\n";



