<?php

require 'IterableCollection.php';
require 'GeneratorsCollection.php';
require 'ResponseAnalizer.php';
require 'Runner.php';

function countTenMore($a, Closure $callback = null) {
	
	for ($b = $a; $b < $a + 10; $b++) {

		echo (yield  $b) . "\n";

	}
	
	if ($callback) {
		yield $callback;
	}
	
}

function doAnotherThing($count, Closure $callback = null) {

	foreach (range(1,$count) as $number) 
	{
		yield (function() use ($number){
					echo "ANOTHER $number\n";
				});
	}
	
	if ($callback) yield $callback;
	
}

function printThings() {

	echo "\n\n\n\n\n";

	foreach (range(1,10) as $number) {

		echo "Things ";

	}

	echo "\n\n\n\n\n";

}

function init() {

	// Concurrent
	yield [
	
		countTenMore(100, function(){ return countTenMore(400); }),
		countTenMore(200, function(){ return countTenMore(500); }),
		countTenMore(300, function(){ return countTenMore(600); })
	
	];
	
	yield function() { printThings(); };

	// Concurrent
	yield [

		doAnotherThing(10, function(){ return countTenMore(700); }),
		doAnotherThing(20, function(){ return countTenMore(800); }),
		doAnotherThing(30, function(){ return countTenMore(900); }),

	];

}

$runner = new Runner(new GeneratorsCollection(), new ResponseAnalizer());
$runner->attach(init());
$runner->run();