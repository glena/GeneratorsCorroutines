<?php

class Runner {

	protected $generators;
	protected $analizer;
	
	public function __construct(IterableCollection $generators, ResponseAnalizer $analizer) {
		
		$this->generators = $generators;
		$this->analizer = $analizer;
		
	}
	
	public function attach($generator) {
		$this->generators->push($generator);
	}

	public function run() {
		
		// It will run shile it has things to run
		while($this->generators->count() > 0) {
		
			foreach($this->generators as $generator) {

				// For each generator, we will create an environment
				
				$childRunner = new Runner(new GeneratorsCollection(), $this->analizer);

				// lets analyze what to do with the data that the generator give us
				$response = $this->analizer->process($generator->current(), $childRunner);
				// and we will send to the routine the data we get from this run (it is usefull for functions returns and stuff)
				$generator->send($response);

				// lets make the routines RUN
				$childRunner->run();
			}
			
			// if any generator is not longer valid (it finished), lets remove it
			$this->generators->clean(function($generator){ return $generator->valid(); });
		}
			
	}

}
