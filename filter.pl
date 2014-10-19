$filename = $ARGV[0];
open(F, $filename);
$text = '';
while ($line = <F>) {
	chop($line);
	print "$line\n";
}
close(F);

