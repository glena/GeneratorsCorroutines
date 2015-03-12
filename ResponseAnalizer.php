<?php

class ResponseAnalizer {

	public function process($response, Runner $childRunner) {
	
		if ($response instanceof Closure ) {
			return $this->process($response(), $childRunner);
		} if ($response instanceof Generator) {
			$childRunner->attach($response);
			return null;
		}
		elseif(is_array($response)) {
			$return = [];
			foreach ($response as $item) {
				$return[] = $this->process($item, $childRunner);
			}
			return $return;
		}
		
		return $response;
	}
}