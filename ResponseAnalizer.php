<?php

class ResponseAnalizer {

	public function process($response, Runner $childRunner) {
	
		if ($response instanceof Closure ) {
			// if the generator give us a closure, we will process it and analyze the response. If it is a generator, it should run
			return $this->process($response(), $childRunner);
		} if ($response instanceof Generator) {
			// seems that it is a generator, will attach to the same environment and make it run later
			$childRunner->attach($response);
			return null;
		}
		elseif(is_array($response)) {
			// if it is an array of things, lets check what to do with each one
			$return = [];
			foreach ($response as $item) {
				$return[] = $this->process($item, $childRunner);
			}
			return $return;
		}
		
		// it is an scalar or an object, lets return so we send it back to the generator
		return $response;
	}
}