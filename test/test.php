<?php

require '../fyshuffle.class.php';


// Check the difference between max and min, this should me no more then 1 at any time.
function test($test){
	if(abs(min($test) - max($test)) > 1) return false;
	return true;
}





// Check range mode
$test = array();
for ($i = 1; $i < 11; $i++) {
	$test[$i] = 0;
}

$shuffle = new FYShuffle(1, 10);
for ($i = 0; $i < 100000; $i++) {
	$result = $shuffle->fetch();
	$test[$result]++;

	if(!test($test)) {
		die('range test failed');		
	}
}

echo 'range ok'.PHP_EOL;





// Check array mode
$array = array('one' => 'blue', 'two' => 'yellow', 'three' => 'red', 'four' => 'green', 'five' => 'orange');

$test = array();
foreach ($array as $x => $y) {
	$test[$y] = 0;
}

$shuffle = new FYShuffle($array);
for ($i = 0; $i < 100000; $i++) {
	$result = $shuffle->fetch();
	$test[$result]++;

	if(!test($test)) {
		print_r($test);
		die('array test failed');		
	}
}

echo 'array ok'.PHP_EOL;
?>
