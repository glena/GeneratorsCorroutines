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
		
		while($this->generators->count() > 0) {
		
			foreach($this->generators as $generator) {
				
				$childRunner = new Runner(new GeneratorsCollection(), $this->analizer);

				$response = $this->analizer->process($generator->current(), $childRunner);
				$generator->send($response);

				$childRunner->run();
			}
			
			$this->generators->clean(function($generator){ return $generator->valid(); });
		}
			
	}

}
