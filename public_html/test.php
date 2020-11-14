<?php
$original = array( 'a', 'b', 'c', 'd', 'e' );
$inserted = array( 'x' ); // Not necessarily an array

array_splice( $original, 3, 0, $inserted );
print_r($original);
?>

